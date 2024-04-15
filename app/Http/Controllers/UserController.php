<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            'nom' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'contrasenya' => ['required'],
            'localitzacio' => ['required', 'string', 'max:255']
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
            'localitzacio' => 'required',
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

    public function login(Request $request)
    {
        // S'han de tenir tots els usuaris amb la mateixa encriptació, si no no funciona
        try {
            $credentials = $request->validate([
                // 'email' => ['required', 'string', 'email'],
                'nom' => ['required', 'string'],
                'contrasenya' => ['required', 'string'],
            ]);

            // Retrieve the user by username
            $user = User::where('nom', $credentials['nom'])->first();

            // Check if the user exists and if the password matches
            if ($user && Hash::check($credentials['contrasenya'], $user->contrasenya)) {
                return response()->json($user, 200);
            } else {
                throw ValidationException::withMessages([
                    'error' => 'Invalid username or password.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout(); // Cerrar sesión del usuario
            return response()->json(['message' => 'Logout successful.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Funcionament amb JWT (JSON Web Token)
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('nom', 'contrasenya');

    //     if (!auth()->attempt($credentials)) {
    //         throw ValidationException::withMessages([
    //             'error' => ['Credenciales inválidas'],
    //         ]);
    //     }

    //     // Autenticación exitosa, generar un token JWT
    //     $token = auth()->attempt($credentials);
    //     return response()->json(['token' => $token]);
    // }

    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Sesión cerrada correctamente']);
    // }

}
