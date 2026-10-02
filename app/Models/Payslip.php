<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'user_id',
        'month',
        'year',
        'basic',
        'hra',
        'allowance',
        'pf',
        'tax',
        'net_pay',
        'credited_on',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}