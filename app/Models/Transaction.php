<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'type',
        'amount',
        'date',
    ];

    // Mostrar monto con signo
    public function getSignedAmountAttribute()
    {
        return $this->type === 'expense' ? -$this->amount : $this->amount;

    }
}
