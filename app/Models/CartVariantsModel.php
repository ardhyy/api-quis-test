<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartVariantsModel extends Model
{
    use HasFactory;

    protected $table = 'cart_variant_products';

    protected $fillable = [
        'cart_id',
        'variant_products_id',
    ];

    public $timestamps = false;
}
