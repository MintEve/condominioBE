<?php

namespace App\Http\Controllers;

// ¡Estos 'use' son la clave para que no te dé errores!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
    public function cambiarPassword(Request $request)
    {
        // 1. Validar que los datos vengan en el formato correcto
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8', 
            // 'confirmed' exige que desde React mandes 'new_password_confirmation'
        ]);

        // 2. Obtener al usuario que está haciendo la petición
        $user = $request->user();

        // 3. Verificar que la contraseña actual ingresada coincida con la real
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'La contraseña actual es incorrecta'], 401);
        }

        // 4. Encriptar y guardar la nueva contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 5. Cierre de sesión global: Borrar todos los tokens de la base de datos
        $user->tokens()->delete();

        // 6. Entregarle un nuevo token para que no se quede afuera en este dispositivo
        $token = $user->createToken('token_dispositivo')->plainTextToken;

        return response()->json([
            'message' => 'Contraseña actualizada y sesiones cerradas en otros dispositivos',
            'token' => $token
        ]);
    }
}