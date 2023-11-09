<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'sales_id',
        'products_id',
        'price',
        'variants_id',
    ];

    public function sale()
    {
        return $this->belongsTo(SalesModel::class, 'sales_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'products_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductsVariantModel::class, 'variants_id', 'id');
    }
}
