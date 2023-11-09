<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    protected $fillable = ['token'];

    public function users()
    {
        return $this->hasMany(User::class, 'token', 'id');
    }
}
