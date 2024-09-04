<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Transactions;

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

    public function getTransaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id', 'id');
    }

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
