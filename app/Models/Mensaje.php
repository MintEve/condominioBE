<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    // 1. ñe decimos el nombre exacto de tu tabla en Postgres
    protected $table = 'mensajes';

    // 2. le decimos cuál es la llave primaria
    protected $primaryKey = 'id';

    // 3.como mis tablas no tienen las columnas 'created_at' y 'updated_at' 
    // que Laravel busca por defecto. desactivamos para que no den error.
    public $timestamps = false;

    // 4. campos que se pueden llenar masivamente
    protected $fillable = [
        'remitente',
        'destinatario',
        'id_depaa',
        'id_depab',
        'mensaje',
        'fecha'
    ];
}