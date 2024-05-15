<?php

namespace App\Http\Controllers;

use App\Models\Inmobiliaria;
use Illuminate\Http\Request;


class InmobiliariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inmobiliaria::all();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:inmobiliarias',
                'telefono' => 'required|string|max:20',
            ]);

            $inmobiliaria = Inmobiliaria::create($request->all());

            return response()->json(['message' => 'Inmobiliaria creada con éxito', 'data' => $inmobiliaria], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inmobiliaria $inmobiliaria)
    {
        return $inmobiliaria;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inmobiliaria $inmobiliaria)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:inmobiliarias,email,' . $inmobiliaria->id,
                'telefono' => 'required|string|max:20',
            ]);

            $inmobiliaria->update($request->only('nombre', 'direccion', 'email', 'telefono'));

            return response()->json(['message' => 'Inmobiliaria actualizada con éxito', 'data' => $inmobiliaria], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()], 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($inmobiliaria)
    {

        $inmobiliariaDelete = Inmobiliaria::find($inmobiliaria);

        if ($inmobiliariaDelete) {
            $nombreInmobiliaria = $inmobiliariaDelete->nombre;
            $inmobiliariaDelete->delete();

            return response()->json(['message' => 'Inmobiliaria ' . $nombreInmobiliaria . ' eliminada con éxito'], 200);
        } else {
            return response()->json(['message' => 'Inmobiliaria no encontrada'], 404);
        }
    }
}
