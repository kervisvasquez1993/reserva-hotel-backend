<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inmueble extends Model
{
    use HasFactory, SoftDeletes ;
    protected $fillable = [
        'inmobiliaria_id',
        'type_of_inmueble_id',
        'tipo_inmueble',
        'nombre',
        'descripcion',
        'precio',
        'direccion',
        'imagen',
        'destacado',
        'latitud',
        'longitud',
        'status',
    ];
    public function inmobiliaria()
    {
        return $this->belongsTo(Inmobiliaria::class);
    }


    public function typeinmueble()
    {
        return $this->belongsTo(TypeOfInmuebles::class);
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function filesImg()
    {
        return $this->hasMany(ImgInmueble::class);
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
