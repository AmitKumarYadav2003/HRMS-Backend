<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PayrollController extends Controller
{
    private array $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    public function index(Request $request)
    {
        $month = $request->get('month', now()->format('F'));
        $year = (int) $request->get('year', now()->year);

        $payslips = Payslip::with('user:id,name,email')
            ->where('month', $month)
            ->where('year', $year)
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.payroll.index', [
            'payslips' => $payslips,
            'month' => $month,
            'year' => $year,
            'months' => $this->months,
        ]);
    }

    public function create() //opens form for new payslip
    {
        return view('admin.payroll.create', $this->formData(new Payslip()));
    }

    public function store(Request $request)
    {
        // Validate the payslip form data, and check for duplicates before creating a new payslip, in draft status.Then redirect to the show page with a success message. 
        $data = $this->validatePayslip($request);

        if ($this->isDuplicate($data)) {
            return back()->withInput()->withErrors([
                'month' => 'payslip already exists for this employee in this month.',
            ]);
        }

        $data['status'] = 'draft';
        $payslip = Payslip::create($data);

        return redirect()->route('admin.payroll.show', $payslip)
            ->with('success', 'Draft payslip saved.');
    }

    public function show(Payslip $payslip)
    {
        $payslip->load('user:id,name,email,department,designation');

        return view('admin.payroll.show', compact('payslip'));
    }

    public function edit(Payslip $payslip)
    {
        //abort means if condition is true ,stop request and return 403 error.
        abort_if($payslip->status === 'approved', 403, 'Approved payslip cannot be edited.');

        return view('admin.payroll.create', $this->formData($payslip));
    }

    public function update(Request $request, Payslip $payslip)
    {
        abort_if($payslip->status === 'approved', 403, 'Approved payslip cannot be edited.');

        $data = $this->validatePayslip($request);

        if ($this->isDuplicate($data, $payslip->id)) {
            return back()->withInput()->withErrors([
                'month' => 'payslip already exists for this employee in this month.',
            ]);
        }

        $payslip->update($data);

        return redirect()->route('admin.payroll.show', $payslip)
            ->with('success', 'Payslip updated.');
    }

    public function approve(Request $request, Payslip $payslip)
    {
        if ($payslip->status === 'approved') {
            return back()->with('error', 'This payslip is already approved.');
        }

        $payslip->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.payroll.show', $payslip)
            ->with('success', 'Payslip approved. Employee will be notified.');
    }

    private function formData(Payslip $payslip): array
    {
        return [
            'payslip' => $payslip,
            'months' => $this->months,
            'employees' => User::where('role', 'employee')->orderBy('name')->get(['id', 'name']),
        ];
    }

    private function validatePayslip(Request $request): array
    {
        $data = $request->validate([
            'user_id' => ['required', Rule::exists('users', 'id')->where('role', 'employee')],
            'month' => ['required', Rule::in($this->months)],
            'year' => 'required|integer|min:2000|max:2100',
            'basic' => 'required|numeric|min:0',
            'hra' => 'required|numeric|min:0',
            'allowance' => 'required|numeric|min:0',
            'pf' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'credited_on' => 'nullable|date',
        ]);

        $gross = $data['basic'] + $data['hra'] + $data['allowance'];

        if (($data['pf'] + $data['tax']) > $gross) {
            throw ValidationException::withMessages([
                'tax' => 'PF and tax total cannot exceed gross earnings.',
            ]);
        }

        return $data;
    }

    private function isDuplicate(array $data, ?int $ignoreId = null): bool
    {
        return Payslip::where('user_id', $data['user_id'])
            ->where('month', $data['month'])
            ->where('year', $data['year'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
    }
}