<?php

namespace App\Http\Controllers;

use App\Models\TipoInmueble;
use Illuminate\Http\Request;

class TipoInmuebleController extends Controller
{
    public function index()
    {
        $types = TipoInmueble::all();
        return response()->json(['data' => $types], 200);
    }
}
