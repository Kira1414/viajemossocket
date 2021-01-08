<?php

namespace App\Models\AutoresHasLibros;

use Illuminate\Database\Eloquent\Model;

class AutoresHasLibros extends Model
{
    protected $table = "autores_has_libros";
    
    protected $fillable = [
        "autores_id",
        "libros_isbn"
    ];

    public function libros()
    {
        return $this->belongsTo('App\Models\Libros');
    }
    
    public function autores()
    {
        return $this->belongsTo('App\Models\Autores');
    }

}
