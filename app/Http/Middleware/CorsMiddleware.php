<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Permitir solicitudes desde cualquier origen
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, X-Auth-Token, Authorization, Accept',
        ];

        if ($request->getMethod() == "OPTIONS") {
            // La solicitud es OPTIONS, solo responde con los encabezados CORS y no continúes con la solicitud
            return response()->json('OK', 200, $headers);
        }

        // Continúa con la solicitud normal
        $response = $next($request);

        // Agrega los encabezados CORS a la respuesta
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
