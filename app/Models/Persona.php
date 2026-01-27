<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    // tabla pgsql
    protected $table = 'personas';

    // Llave primaria
    protected $primaryKey = 'id';

    // Como no usamos las columnas automáticas de Laravel (created_at/updated_at)
    public $timestamps = false;

    // campos  que permitimos que se llenen desde el código
    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'celular',
        'activo'
    ];
}
