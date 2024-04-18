<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Middleware\CheckTokenExpiration;
use \Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'contrasenya' => ['required'],
            'codilocalitzacio' => ['required', 'integer']
        ]);

        // Hash the password before storing it
        $data['contrasenya'] = Hash::make($data['contrasenya']);

        $user = User::create($data);

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $data = $request->validate([
            'nom' => 'required',
            'contrasenya' => 'required',
            'codilocalitzacio' => 'required',
            // 'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Hash the password before updating it
        if (isset($data['contrasenya'])) {
            $data['contrasenya'] = Hash::make($data['contrasenya']);
        }

        $user->update($data);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }

    // Funcionament amb JWT (JSON Web Token)
    public function login(Request $request)
    {
        $credentials = $request->only('nom', 'contrasenya');

        // echo "Credentials: " . json_encode($credentials) . PHP_EOL;

        try {
            $user = User::where('nom', $credentials['nom'])->first();

            if (!$user || !Hash::check($credentials['contrasenya'], $user->contrasenya)) {
                // Authentication failed
                throw new Exception('Credenciales inválidas: Usuario o contraseña incorrectos');
            }

            // Generate JWT token
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token,
                'user' => $user // Opcional: puedes enviar los datos del usuario en la respuesta
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function verifyAuth()
    {
        try {
            // Verificar si el token proporcionado es válido
            $user = Auth::user();

            // El token es válido, el usuario está autenticado
            return response()->json(['message' => 'Token is valid'], 200);
        } catch (Exception $e) {
            // Manejar el error si el token no es válido o ha expirado
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'TokenExpired'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'TokenInvalid'], 401);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
    }
}
