<?php

namespace App\Http\Controllers;

use App\EquipmentType;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('equipmentType.index', ['equipmentTypes' => EquipmentType::orderBy('name')->where('parent_id', null)->where('folder', 1)->get()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\EquipmentTypeRequest|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\EquipmentTypeRequest $request)
    {
        $equipmentType = EquipmentType::create([
            'name' => Input::get('name'),
            'folder' => Input::get('folder')==1?1:0,
            'parent_id' => !empty(Input::get('parent_id'))?Input::get('parent_id'):null
        ]);
        return view('equipmentType._list_item', ['equipmentType' => $equipmentType, 'deep' => Input::get('deep')+1])->render();
//        return redirect(route('equipment-types.show', [$equipmentType->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('equipmentType.show', ['equipmentType' => EquipmentType::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipmentType = EquipmentType::find($id);
        return \Response::json($equipmentType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\EquipmentTypeRequest|\Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\EquipmentTypeRequest $request, $id)
    {
        $equipmentType = EquipmentType::find($id);
        $equipmentType->name = Input::get('name');
        $equipmentType->save();
        return response('Equipment type saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EquipmentType::find($id)->delete();
        return response('Equipment type successfully deleted!');
    }

    public function getItems($id, $deep, Request $request)
    {
        if($request->ajax()){
            $responseHTML = '<div>';
            $equipmentType = EquipmentType::find($id);
            foreach ($equipmentType->childTypes->sortByDesc('folder') as $type){
                $responseHTML .= view('equipmentType._list_item', ['equipmentType' => $type, 'deep' => $deep + 1])->render();
            }
            return $responseHTML.'</div>';
        }
        return abort('405', 'Method Not Allowed');

    }
}
