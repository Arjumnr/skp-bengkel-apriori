<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsItems extends Model
{
    use HasFactory;
    protected $table = 'transactions_items';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'price',
    ];
}
