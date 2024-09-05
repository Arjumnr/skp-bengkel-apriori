<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'name',
        'stock', //stok
        'capital', //modal
        'sell', //keuntungan

    ];

    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'rule_product', 'product_id', 'rule_id');
    }
}
