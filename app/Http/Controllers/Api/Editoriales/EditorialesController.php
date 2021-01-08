<?php

namespace App\Http\Controllers\Api\Editoriales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Editoriales\Editoriales;
use App\Http\Requests\CreateEditorialesRequest;
use App\Http\Requests\UpdateEditorialesRequest;
use App\Events\Editoriales\CreateEditorialesEvent;
use App\Events\Editoriales\UpdateEditorialesEvent;
use App\Events\Editoriales\DeleteEditorialesEvent;

class EditorialesController extends Controller
{
    public function list()
    {
        
        return DataTables::of(Editoriales::where("status", true))->make();
    }

    public function get($id)
    {
        $result = Editoriales::where("id", $id)->first();
        return response()->json($result);
    }
    
    public function create(CreateEditorialesRequest $request)
    {
        
        $result = ["result"=>"OK", "message"=>"Creado correctamente"];
        $create = Editoriales::create($request->all());
        if(!$create)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido crear"];
        }

        broadcast(new CreateEditorialesEvent($create->id, $create->nombre, $create->sede, $create->status))->toOthers();
        return response()->json($result);
    }
    
    public function update(UpdateEditorialesRequest $request, $id)
    {
        $result = ["result"=>"OK", "message"=>"Actualizado correctamente"];
        $update = Editoriales::where("id", $id)->update($request->all());
        if(!$update)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido eliminar"];
        }
        broadcast(new UpdateEditorialesEvent($id, $request->nombre, $request->sede))->toOthers();
        

        return response()->json($result);

    }
    
    public function delete($id)
    {
        $result = ["result"=>"OK", "message"=>"Eliminado correctamente"];
        $delete = Editoriales::where("id", $id)->update(["status" => false]);
        if(!$delete)
        {
            $result = ["result"=>"KO", "message"=>"No se ha podido eliminar"];
        }
        broadcast(new DeleteEditorialesEvent($id, false))->toOthers();
        return response()->json($result);
    }
}
