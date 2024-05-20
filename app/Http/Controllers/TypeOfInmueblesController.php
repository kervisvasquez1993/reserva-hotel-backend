<?php

namespace App\Http\Controllers;

use App\Models\TypeOfInmuebles;
use Illuminate\Http\Request;

class TypeOfInmueblesController extends Controller
{
    public function index()
    {
        $types = TypeOfInmuebles::all();
        return response()->json(['data' => $types], 200);
    }
}
