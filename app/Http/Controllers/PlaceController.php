<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Place;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('place.index')->with('places', Place::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('place.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PlaceRequest|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PlaceRequest $request)
    {
        $place = (new Place())->fill($request->all());
        $place->save();
        return redirect()->route('places.show', [$place->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::with(['users.equipments'])->where('id', $id)->first();
        $busyEquipments = Equipment::has('users')->get()->modelKeys();
        return view('place.show', ['place' => $place, 'equipments' => $place->equipments->except($busyEquipments)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = Place::findOrFail($id);
        return view('place.edit')->with('place', $place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Place::findOrFail($id);
        $place->fill($request->all())->save();
        return redirect()->route('places.show', [$place->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return redirect()->route('places.index');
    }

    public function addUsers($id)
    {
        return view('place.addUsers',['placeId'=> $id, 'users' => User::freeUsers()]);
    }

    public function storeUsers($id)
    {
        $attach = array_fill_keys(Input::get('users'), ['from' => Carbon::today()]);
        /* @var Place $place */
        $place = Place::findOrFail($id);

        $place->users()->attach($attach);
        return redirect()->route('places.show', [$place->id]);
    }

    public function unPinUser($id, $userId)
    {
        /* @var Place $place */
        $place = Place::findOrFail($id);
        /* @var User $user */
        $user = User::findOrFail($userId);
        $user->equipments()->syncWithoutDetaching(array_fill_keys($user->equipments->modelKeys(), ['to' => Carbon::today()]));
        $place->users()->syncWithoutDetaching([$userId => ['to' => Carbon::today()]]);
        return redirect()->route('places.show', [$place->id]);
    }

    public function deleteUsers($id, $userId)
    {
        /* @var Place $place */
        $place = Place::findOrFail($id);
        /* @var User $user */
        $user = User::findOrFail($userId);
        $user->equipments()->detach();
        $place->users()->detach($userId);
        return redirect()->route('places.show', [$place->id]);
    }

    public function addEquipments($id)
    {
        return view('place.addEquipments', ['placeId' => $id, 'equipments' => Equipment::freeEquipments()]);
    }

    public function storeEquipments($id)
    {
        $attachEquipments = array_fill_keys(Input::get('equipments'), ['from' => Carbon::today()]);
        /* @var Place $place */
        $place = Place::findOrFail($id);
        $place->equipments()->attach($attachEquipments);
        return redirect()->route('places.show', [$id]);
    }

    public function unPinEquipment($id, $equipmentId)
    {
        /* @var Place $place */
        $place = Place::findOrFail($id);
        $place->equipments()->syncWithoutDetaching([$equipmentId => ['to' => Carbon::today()]]);
        return redirect()->route('places.show', [$place->id]);
    }

    public function deleteEquipment($id, $equipmentId)
    {
        /* @var Place $place */
        $place = Place::findOrFail($id);
        $place->equipments()->detach($equipmentId);
        return redirect()->route('places.show', [$place->id]);
    }
}
