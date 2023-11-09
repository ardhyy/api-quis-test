<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsMethodModel extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'name',
        'account_number',
        'account_holder',
    ];

    public $timestamps = false;

    public function sales()
    {
        return $this->hasMany(SalesModel::class, 'payment', 'id');
    }
}
