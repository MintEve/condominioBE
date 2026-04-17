<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RecuperarPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // React nos envíe un correo y una contraseña
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // intentar validar las credenciales en la base de datos
        // Auth::attempt busca el correo y comprueba si la contraseña encriptada coincide
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'mensaje' => 'Correo o contraseña incorrectos. Intenta de nuevo.'
            ], 401); 
        }
        // Si las credenciales son correctas, buscamos al usuario
        $user = User::where('email', $request->email)->firstOrFail();

        // Creamos su "gafete virtual" (Token) usando Sanctum
        $token = $user->createToken('token_de_acceso')->plainTextToken;

        //respondemos a React entregándole los datos y el token
        return response()->json([
            'mensaje' => '¡Inicio de sesión exitoso!',
            'usuario' => $user,
            'token' => $token
        ]);
    }

    public function forgotPassword(Request $request)
{
        //Validar que nos envíen un correo válido
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generar un código aleatorio de 6 dígitos
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Guardarlo en la libreta temporal (borramos si había uno viejo primero)
        DB::table('password_reset_codes')->where('email', $request->email)->delete();
        DB::table('password_reset_codes')->insert([
            'email' => $request->email,
            'code' => $code,
            'created_at' => now()
        ]);

        // enviar correo
        Mail::to($request->email)->send(new RecuperarPassword($code));

        return response()->json([
            'mensaje' => 'Código de recuperación enviado a tu correo.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        // pedimos codigo, contraseña y tmb el codigo que se les envió
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string',
            'password' => 'required|min:6' // Mínimo 6 caracteres para la nueva clave
        ]);

        // revisamos  en nuestra libreta temporal si el código coincide con el correo
        $registroValido = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        // Si el código no existe o lo escribió mal 
        if (!$registroValido) {
            return response()->json([
                'mensaje' => 'El código es incorrecto o ha expirado.'
            ], 400); // 400 significa "Petición Incorrecta"
        }

        //si todo esta bien buscamos al usuario y le ponemos su nueva contraseña (encriptada)
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // borrar TODOS los tokens de este usuario sus tokens desaparecen de la db y la sesión se cierra sola
        $user->tokens()->delete();

        // destruir el código temporal para que no lo puedan volver a usar
        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        return response()->json([
            'mensaje' => 'Contraseña actualizada exitosamente, las sesiones anteriores han sido cerradas.'
        ]);
    }

    public function logout(Request $request)
{
        // Buscamos el token que el usuario está usando ahorita y lo borramos
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada exitosamente en el servidor'
        ]);
    }
}