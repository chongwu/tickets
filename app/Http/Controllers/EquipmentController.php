<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class EquipmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipment.create');
    }

    public function createFor($id)
    {
        return view('equipment.create')->with('equipmentType', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\EquipmentRequest|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\EquipmentRequest $request)
    {
        $equipment = (new Equipment())->fill($request->all());
        $equipment->save();
        return redirect()->route('equipments.show', [$equipment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.show')->with('equipment', $equipment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.edit')->with('equipment', $equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\EquipmentRequest|\Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\EquipmentRequest $request, $id)
    {
        /* @var Equipment $equipment */
        $equipment = Equipment::findOrFail($id);
        $equipment->fill($request->all());
        $equipment->save();
        return redirect()->route('equipments.show', [$equipment->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* @var Equipment $equipment */
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return redirect()->route('equipment-types.show', [$equipment->equipment_type_id]);
    }
}
