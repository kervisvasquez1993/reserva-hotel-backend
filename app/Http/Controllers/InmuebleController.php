<?php

namespace App\Http\Controllers;

use App\Http\Resources\InmuebleResource;
use App\Models\Inmobiliaria;
use App\Models\Inmueble;
use App\Models\ImgInmueble;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class InmuebleController extends Controller
{

    public function calificaciones($id)
    {
        $inmueble = Inmueble::find($id);
        if (!$inmueble) {
            return response()->json(['message' => 'Inmueble no encontrado'], 404);
        }
        $calificaciones = $inmueble->calificaciones;
        return response()->json($calificaciones, Response::HTTP_OK);
    }

    public function uploadFile(Request $request, $id){
        $inmueble = Inmueble::find($id);
        if (!$inmueble) {
            return response()->json(['message' => 'Inmueble no encontrado'], 404);
        }

        try{
        $request->validate([
            'type' => 'required|string|in:youtube,upload-video,imagen',
            'url' => 'required_if:type,youtube',
             'img_file' => 'required_if:type,upload-video,imagen|file|max:10240|mimes:mp4,jpg,jpeg,png', // max 10MB
        ]);
        $type = $request->input('type');
        if ($type == 'youtube') {
            $url = $request->input('url');
        } else {
            $file = $request->file("img_file");
            $path = $file->storePublicly("public/imagen", 's3');
            $url = "https://my-bucket-img-laravel-kervis.s3.amazonaws.com/" . $path;
        }
    
        $imgInmueble = ImgInmueble::create([
            'inmueble_id' => $id,
            'url' => $url,
            'type' => $type
        ]);
    
        return response()->json(['message' => 'Archivo subido con éxito', 'data' => $imgInmueble], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['message' => $e->validator->errors()], 400);
    }
    
    }
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
    public function show( $id)
    {
        $inmueble = Inmueble::find($id);
    
        if (!$inmueble) {
            return response()->json(['message' => 'Inmueble no encontrado'], 404);
        }
        return $inmueble;
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $inmuebles = Inmueble::find($id);
    
        if (!$inmuebles) {
            return response()->json(['message' => 'Inmueble no encontrado'], 404);
        }
        try {
            $inmobiliaria_id = $inmuebles->inmobiliaria->user_id;
            $user_id = auth()->user()->id;
            if ($user_id != $inmobiliaria_id) {
                return response()->json(['message' => 'No tienes permisos para editar este inmueble'], 403);
            }
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

            if (!Inmobiliaria::find($inmuebles->inmobiliaria->id)) {
                return response()->json(['message' => 'Inmobiliaria no encontrada'], 404);
            }

            $inmuebles->update($request->all());

            return response()->json(['message' => 'Inmueble actualizado con éxito', 'data' => $inmuebles], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inmueble = Inmueble::find($id);
    
        if (!$inmueble) {
            return response()->json(['message' => 'Inmueble no encontrado'], 404);
        }
    
        $inmobiliaria_id = $inmueble->inmobiliaria->user_id;
        $user_id = auth()->user()->id;
        if ($user_id != $inmobiliaria_id) {
            return response()->json(['message' => 'No tienes permisos para editar este inmueble'], 403);
        }
    
        $inmuebleId = $inmueble->id;
        $inmueble->delete();
    
        return response()->json([
            'message' => 'Inmueble eliminado con éxito',
            'id' => $inmuebleId
        ], 200);
    }

  
}
