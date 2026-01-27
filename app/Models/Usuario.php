<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'pass',
        'admin'
    ];

    // ocultar el password para que no se envíe 
    // por accidente en las respuestas de la API
    protected $hidden = [
        'pass',
    ];
}