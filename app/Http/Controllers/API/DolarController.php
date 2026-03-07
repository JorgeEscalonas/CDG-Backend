<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dolar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DolarController extends Controller
{
    /**
     * Obtener el último precio del dólar
     */
    public function obtenerUltimoPrecio(): JsonResponse
    {
        $ultimoPrecio = Dolar::obtenerUltimoPrecio();

        return response()->json([
            'success' => true,
            'data' => $ultimoPrecio ? (new \App\Http\Resources\API\DolarResource($ultimoPrecio))->resolve() : null
        ]);
    }

    /**
     * Obtener todos los precios históricos
     */
    public function obtenerHistorial(): JsonResponse
    {
        $precios = Dolar::orderBy('fecha_actualizacion', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => \App\Http\Resources\API\DolarResource::collection($precios)->resolve()
        ]);
    }

    /**
     * Obtener tasa desde API externa (BCV)
     */
    /**
     * Obtener tasa desde API externa (BCV)
     */
    public function obtenerTasaAPI(): JsonResponse
    {
        try {
            // Usando la API de Scraping BCV proporcionada por el usuario
            $response = Http::get('https://scraping-bcv.vercel.app/api/rates');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // La API devuelve { success: true, rates: [...] } 
                // O según el ejemplo un array directo. Manejamos ambos casos.
                $rates = isset($data['rates']) ? $data['rates'] : $data;
                
                // Buscamos el objeto que corresponde al Dólar
                $dolarData = null;
                if (is_array($rates)) {
                    foreach ($rates as $rate) {
                        if (isset($rate['nombre']) && ($rate['nombre'] === 'Dólar' || $rate['nombre'] === 'Dolar')) {
                            $dolarData = $rate;
                            break;
                        }
                    }
                }

                $precio = $dolarData['promedio'] ?? null;

                if ($precio) {
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'precio' => (float) $precio,
                            'fuente' => 'BCV (Oficial)'
                        ]
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener la tasa desde el BCV'
            ], 502);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión con la API externa'
            ], 500);
        }
    }

    /**
     * Guardar nuevo precio del dólar
     */
    public function guardarPrecio(\App\Http\Requests\API\StoreDolarRequest $request): JsonResponse
    {
        $dolar = Dolar::create([
            'precio' => $request->precio,
            'fecha_actualizacion' => now()
        ]);

        /*
        // Limpiar caché
        Cache::forget('ultimo_precio_dolar');
        */

        return response()->json([
            'success' => true,
            'message' => 'Precio guardado exitosamente',
            'data' => (new \App\Http\Resources\API\DolarResource($dolar))->resolve()
        ], 201);
    }
}

