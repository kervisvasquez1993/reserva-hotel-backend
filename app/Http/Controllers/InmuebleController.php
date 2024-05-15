<?php

namespace App\Http\Controllers;

use App\Http\Resources\InmuebleResource;
use App\Models\Inmobiliaria;
use App\Models\Inmueble;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class InmuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inmueble::query();
        if ($request->has('inmobiliarias_id')) {
            $query->where('inmobiliaria_id', $request->query('inmobiliarias_id'));
        }
        if ($request->has('destacado')) {
            $query->where('destacado', $request->query('destacado') === 'true' ? true : false);
        }
        $inmuebles = $query->latest()->paginate(10);
        $resource = InmuebleResource::collection($inmuebles);
        $response = [
            'lastPage' => $inmuebles->lastPage(),
            'currentPage' => $inmuebles->currentPage(),
            'total' => $inmuebles->total(),
            'data' => $resource
        ];

        return response()->json($response, Response::HTTP_OK);
    }
    public function store(Request $request)
    {

        try {
            $inmobiliaria_id = $request->query('inmobiliarias');
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric',
                'direccion' => 'required|string|max:255',
                'imagen' => 'required|string',
                'video_url' => 'required|string',
                'destacado' => 'required|boolean',
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
            ]);

            if (!Inmobiliaria::find($inmobiliaria_id)) {
                return response()->json(['message' => 'Inmobiliaria no encontrada'], 404);
            }

            $inmueble = Inmueble::create(array_merge($request->all(), ['inmobiliaria_id' => $inmobiliaria_id]));

            return response()->json(['message' => 'Inmueble creado con éxito', 'data' => $inmueble], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inmueble $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inmueble $inmueble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inmueble $inmueble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inmueble $inmueble)
    {
        //
    }
}
