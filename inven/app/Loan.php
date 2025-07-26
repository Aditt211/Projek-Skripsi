<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'borrower_name',
        'borrower_phone',
        'commodity_id',
        'quantity',
        'loan_date',
        'due_date',
        'return_date',
        'purpose',
        'notes',
        'status'
    ];

    protected $casts = [
        'loan_date' => 'datetime:Y-m-d',
        'due_date' => 'datetime:Y-m-d',
        'return_date' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }

    public function getFormattedLoanDateAttribute()
    {
        return $this->loan_date ? Carbon::parse($this->loan_date)->format('d/m/Y') : '-';
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? Carbon::parse($this->due_date)->format('d/m/Y') : '-';
    }

    public function getFormattedReturnDateAttribute()
    {
        return $this->return_date ? Carbon::parse($this->return_date)->format('d/m/Y') : '-';
    }
}
