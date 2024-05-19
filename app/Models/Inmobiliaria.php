<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inmobiliaria extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nombre',
        'direccion',
        'status',
        'email',
        'telefono',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
