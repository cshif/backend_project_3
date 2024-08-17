<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'user_id',
        'type',
        'currency_type',
        'note',
        'balance_before_transaction',
        'balance_after_transaction',
        'status',
        'source_account_id',
        'destination_account_id',
    ];
}
