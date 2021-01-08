<?php

namespace App\Models\Editoriales;

use Illuminate\Database\Eloquent\Model;

class Editoriales extends Model
{
    protected $table = "editoriales";

    protected $fillable = [
        "nombre",
        "sede",
        "status"
    ];

    public function libros()
    {
        return $this->hasMany('App\Models\Libros\Libros');
    }
}
