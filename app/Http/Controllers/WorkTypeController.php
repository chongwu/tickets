<?php

namespace App\Http\Controllers;

use App\WorkType;

use App\Http\Requests;

class WorkTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('workType.index')->with('workTypes', WorkType::with('equipmentType')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\WorkTypeRequest|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\WorkTypeRequest $request)
    {
        $workType = (new WorkType())->fill($request->all());
        $workType->save();
        return redirect()->route('work-types.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workType = WorkType::findOrFail($id);
        return view('workType.edit')->with('workType', $workType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\WorkTypeRequest|\Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\WorkTypeRequest $request, $id)
    {
        $workType = WorkType::findOrFail($id);
        $workType->fill($request->all());
        $workType->save();
        return redirect()->route('work-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WorkType::findOrFail($id)->delete();
        return redirect()->route('work-types.index');
    }
}
