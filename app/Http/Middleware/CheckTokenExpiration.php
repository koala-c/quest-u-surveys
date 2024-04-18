<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Ejecutar el siguiente middleware en la cadena y obtener la respuesta
            $response = $next($request);

            // Verificar si la respuesta es una instancia de Response
            if ($response instanceof Response) {
                return $response;
            }

            // Si no es una instancia de Response, devolver la respuesta original del siguiente middleware
            return $response;
        } catch (TokenExpiredException $e) {
            // Captura la excepción de token expirado
            return response()->json(['message' => 'El token ha expirado'], Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $e) {
            // Captura cualquier otra excepción que pueda ocurrir
            return response()->json(['message' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
