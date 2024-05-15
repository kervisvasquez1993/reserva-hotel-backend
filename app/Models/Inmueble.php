<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    use HasFactory;
    protected $fillable = [
        'inmobiliaria_id',
        'nombre',
        'descripcion',
        'precio',
        'direccion',
        'imagen',
        'video_url',
        'destacado',
        'latitud',
        'longitud',
    ];
    public function inmobiliaria()
    {
        return $this->belongsTo(Inmobiliaria::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function rentas()
    {
        return $this->hasMany(Renta::class);
    }
}