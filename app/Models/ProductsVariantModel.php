<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsVariantModel extends Model
{
    use HasFactory;

    protected $table = 'products_variant';

    protected $fillable = [
        'products',
        'name',
        'additional_price',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'products', 'id');
    }

    public function carts()
    {
        return $this->belongsToMany(CartModel::class, 'cart_variant_products', 'variant_products_id', 'cart_id');
    }
}
