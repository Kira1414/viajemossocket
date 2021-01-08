<?php

namespace App\Models\Libros;

use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    protected $table = "libros";

    protected $fillable = [
        "editoriales_id",
        "titulo",
        "sinopsis",
        "n_paginas",
        "status"
    ];

    public function autoresHasLibros()
    {
        return $this->hasMany('App\Models\Libros\AutoresHasLibros');
    }

    public function editoriales()
    {
        return $this->belongsTo('App\Models\Editoriales\Editoriales');
    }
}
