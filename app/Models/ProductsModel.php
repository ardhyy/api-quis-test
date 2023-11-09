<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'desc',
        'price',
    ];

    public $timestamps = false;

    public function variants()
    {
        return $this->hasMany(ProductsVariantModel::class, 'products', 'id');
    }
}
