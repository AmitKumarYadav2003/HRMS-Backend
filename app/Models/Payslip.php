<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'user_id', 'month', 'year', 'basic', 'hra', 'allowance',
        'pf', 'tax', 'credited_on', 'status', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'basic' => 'float',
        'hra' => 'float',
        'allowance' => 'float',
        'pf' => 'float',
        'tax' => 'float',
        'net_pay' => 'float',
        'credited_on' => 'date:Y-m-d',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Save hone se pehle net pay apne aap calculate ho
        static::saving(function (Payslip $payslip) {
            $payslip->net_pay = $payslip->gross - $payslip->total_deductions;
        });
    }

    public function getGrossAttribute(): float
    {
        return $this->basic + $this->hra + $this->allowance;
    }

    public function getTotalDeductionsAttribute(): float
    {
        return $this->pf + $this->tax;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}