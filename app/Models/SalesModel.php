<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'id',
        'total_price',
        'payment',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentsMethodModel::class, 'payment', 'id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'sales_id', 'id');
    }
}
