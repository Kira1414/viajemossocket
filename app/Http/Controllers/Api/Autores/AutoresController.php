<?php

namespace App\Http\Controllers\Api\Autores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Autores\Autores;
use App\Http\Requests\CreateAutoresRequest;
use App\Http\Requests\UpdateAutoresRequest;
use App\Events\Autores\CreateAutoresEvent;
use App\Events\Autores\UpdateAutoresEvent;
use App\Events\Autores\DeleteAutoresEvent;

class AutoresController extends Controller
{
    public function list()
    {
        
        return DataTables::of(Autores::where("status", true))->make();
    }

    public function get($id)
    {
        $result = Autores::where("id", $id)->first();
        return response()->json($result);
    }
    
    public function create(CreateAutoresRequest $request)
    {
        
        $result = ["result"=>"OK", "message"=>"Creado correctamente"];
        $create = Autores::create($request->all());
        if(!$create)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido crear"];
        }
        broadcast(new CreateAutoresEvent($create->id, $create->nombre, $create->apellidos, $create->status))->toOthers();
        return response()->json($result);
    }
    
    public function update(UpdateAutoresRequest $request, $id)
    {
        $result = ["result"=>"OK", "message"=>"Actualizado correctamente"];
        $update = Autores::where("id", $id)->update($request->all());
        if(!$update)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido eliminar"];
        }
        broadcast(new UpdateAutoresEvent($id, $request->nombre, $request->apellidos))->toOthers();
        return response()->json($result);

    }
    
    public function delete($id)
    {
        $result = ["result"=>"OK", "message"=>"Eliminado correctamente"];
        $delete = Autores::where("id", $id)->update(["status" => false]);
        if(!$delete)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido eliminar"];
        }
        broadcast(new DeleteAutoresEvent($id, false))->toOthers();
        return response()->json($result);
    }
    
}
