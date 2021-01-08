<?php

namespace App\Http\Controllers\Api\Libros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Libros\Libros;
use App\Http\Requests\CreateLibrosRequest;
use App\Http\Requests\UpdateLibrosRequest;
use App\Events\Libros\CreateLibrosEvent;
use App\Events\Libros\UpdateLibrosEvent;
use App\Events\Libros\DeleteLibrosEvent;

class LibrosController extends Controller
{
    public function list()
    {

        $libros = Libros::with("editoriales")->where("libros.status", true);
        //dd($libros->get());
        return DataTables::of($libros)->make();
    }

    public function get($id)
    {
        $result = Libros::where("isbn", $id)->first();
        return response()->json($result);
    }
    
    public function create(CreateLibrosRequest $request)
    {
        
        $result = ["result"=>"OK", "message"=>"Creado correctamente"];
        $create = Libros::create($request->all());
        if(!$create)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido crear"];
        }
        broadcast(new CreateLibrosEvent($create->isbn, $create->editoriales_id, $create->titulo, $create->sinopsis, $create->n_paginas, $create->status))->toOthers();
        return response()->json($result);
    }
    
    public function update(UpdateLibrosRequest $request, $id)
    {
        $result = ["result"=>"OK", "message"=>"Actualizado correctamente"];
        $update = Libros::where("isbn", $id)->update($request->all());
        if(!$update)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido eliminar"];
        }
        broadcast(new UpdateLibrosEvent($id, $request->editoriales_id, $request->titulo, $request->sinopsis, $request->n_paginas))->toOthers();
        return response()->json($result);

    }
    
    public function delete($id)
    {
        $result = ["result"=>"OK", "message"=>"Eliminado correctamente"];
        $delete = Libros::where("isbn", $id)->update(["status" => false]);
        if(!$delete)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido eliminar"];
        }
        broadcast(new DeleteLibrosEvent($id, false))->toOthers();
        return response()->json($result);
    }
}
