<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Inmueble;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    
    public function store(Request $request)
    {
       try{
        $request->validate([
            'inmueble_id' => 'required|exists:inmuebles,id',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_venta' => 'required|date',
        ]);
    
        // Comprueba si el inmueble está alquilado o vendido
        $inmueble = Inmueble::find($request->inmueble_id);
        if ($inmueble->status == 'alquilado') {
            return response()->json(['message' => 'No se puede vender un inmueble que está alquilado'], 400);
        }
    
        if ($inmueble->status == 'vendido') {
            return response()->json(['message' => 'No se puede vender un inmueble que ya se vendió'], 400);
        }
    
        // Si no está alquilado ni vendido, procede a crear la venta
        $venta = Venta::create([
            'inmueble_id' => $request->inmueble_id,
            'user_id' => auth()->user()->id,
            'precio' => $request->precio_venta,
            'fecha_venta' => $request->fecha_venta,
        ]);
    
        // Actualiza el estado del inmueble a "vendido"
        $inmueble->status = 'vendido';
        $inmueble->save();
    
        return response()->json(['message' => 'Venta creada con éxito', 'data' => $venta], 200);
       } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['message' => $e->validator->errors()], 400);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
