<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'inmueble_id',
        'user_id',
        'fecha',
        'precio',
    ];

    public function inmueble()
    {
        return $this->belongsTo(Inmueble::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
