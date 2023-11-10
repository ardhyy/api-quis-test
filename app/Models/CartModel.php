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
    ];

    public $timestamps = false;

    public function sale()
    {
        return $this->belongsTo(SalesModel::class, 'sales_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'products_id', 'id');
    }

    public function variants()
    {
        return $this->belongsToMany(ProductsVariantModel::class, 'cart_variant_products', 'cart_id', 'variant_products_id');
    }
}
