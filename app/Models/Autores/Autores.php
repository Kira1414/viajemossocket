<?php

namespace App\Models\Autores;

use Illuminate\Database\Eloquent\Model;

class Autores extends Model
{
    protected $table = "autores";

    protected $fillable = [
        "nombre",
        "apellidos",
        "status"
    ];

    public function autoresHasLibros()
    {
        return $this->hasMany('App\Models\Libros\AutoresHasLibros');
    }
}
