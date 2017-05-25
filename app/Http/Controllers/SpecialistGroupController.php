<?php

namespace App\Http\Controllers;

use App\SpecialistGroup;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class SpecialistGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('group.index')->with('groups', SpecialistGroup::with(['workTypes', 'users'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\SpecialistGroupRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SpecialistGroupRequest $request)
    {
        $group = new SpecialistGroup();
        $group->fill($request->all());
        $group->save();
        $group->workTypes()->attach(Input::get('workTypes'));
        $group->users()->attach(Input::get('users'));
        return redirect()->route('groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = SpecialistGroup::findOrFail($id);
        return view('group.edit')->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\SpecialistGroupRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SpecialistGroupRequest $request, $id)
    {
        /* @var SpecialistGroup $group */
        $group = SpecialistGroup::findOrFail($id)->fill($request->all());
        $group->save();
        $group->workTypes()->sync(Input::get('workTypes'));
        $group->users()->sync(Input::get('users'));
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SpecialistGroup::findOrFail($id)->delete();
        return redirect()->route('groups.index');
    }
}
