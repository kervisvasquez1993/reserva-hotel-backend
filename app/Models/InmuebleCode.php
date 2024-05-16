<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InmuebleCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'inmueble_id',
        'user_id',
        'code'
    ];
}
