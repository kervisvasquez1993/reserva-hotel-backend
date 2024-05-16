<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $user_id = auth()->user()->id;
        $request->validate([
            'inmueble_id' => 'required|integer|exists:inmuebles,id',
            'estrellas' => 'required|numeric|between:0,5',
        ]);

        $existingCalificacion = Calificacion::where('inmueble_id', $request->inmueble_id)
            ->where('user_id', $user_id)
            ->first();

        if ($existingCalificacion) {
            return response()->json(['message' => 'Ya has calificado este inmueble'], 400);
        }

        $request->merge(['user_id' => $user_id]);

        $calificacion = Calificacion::create($request->all());

        return response()->json(['message' => 'Calificación creada con éxito', 'data' => $calificacion], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['message' => $e->validator->errors()], 400);
    }
}
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
        $calificacion = Calificacion::find($id);
        if (!$calificacion) {
            return response()->json(['message' => 'Calificación no encontrada'], 404);
        }

        $user_id = auth()->user()->id;
        if ($user_id != $calificacion->user_id) {
            return response()->json(['message' => 'No tienes permisos para editar esta calificación'], 403);
        }
        $request->validate([
            'estrellas' => 'required|numeric|between:0,5',
            'comentarios' => 'nullable|string',
        ]);
    
        $calificacion->update($request->only('estrellas', 'comentarios'));
    
        return response()->json(['message' => 'Calificación actualizada con éxito', 'data' => $calificacion], 200);
    }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $calificacion = Calificacion::find($id);

    if (!$calificacion) {
        return response()->json(['message' => 'Calificación no encontrada'], 404);
    }

    $user_id = auth()->user()->id;
    if ($user_id != $calificacion->user_id) {
        return response()->json(['message' => 'No tienes permisos para eliminar esta calificación'], 403);
    }

    $calificacionId = $calificacion->id;
    $calificacion->delete();

    return response()->json([
        'message' => 'Calificación eliminada con éxito',
        'id' => $calificacionId
    ], 200);
}
}
