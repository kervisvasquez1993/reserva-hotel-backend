<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImgInmueble extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'inmueble_id',
        'url',
        'type'
    ];

    public function inmueble()
    {
        return $this->belongsTo(Inmueble::class);
    }


}
