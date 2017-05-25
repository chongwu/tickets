<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Ticket;
use App\User;

use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index')->with('users', User::paginate(30));
    }

    public function show($id)
    {
        $user = User::with(['equipments', 'places'])->where('id', $id)->first();
        if($user){
            return view('user.show')->with('user', $user);
        }
        return abort(404);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'telegram_id' => 'integer|nullable'
        ]);
        /* @var User $user */
        $user = User::findOrFail($id);
        $user->telegram_id = (empty(Input::get('telegram_id')))?null:Input::get('telegram_id');
        $user->save();
        return redirect()->route('users.index');
    }

    public function addEquipment($id)
    {
        /* @var User $user */
        $user = User::findOrFail($id);
        if(!$user->places->isEmpty()){
            $busyEquipments = Equipment::has('users')->get()->modelKeys();
            $notBusyEquipments = $user->places[0]->equipments()->get(['id', 'name', 'inventory_number'])->except($busyEquipments)->pluck('fullName', 'id');
            return view('user.addEquipments', ['userId' => $user->id, 'equipments' => $notBusyEquipments]);
        }
        return view('user.show', [$id])->with('user', $user);
    }

    public function storeEquipment($id)
    {
        /* @var User $user */
        $user = User::findOrFail($id);
        $user->equipments()->attach(array_fill_keys(Input::get('equipments'), ['from' => Carbon::today()]));
        return redirect()->route('places.show', [$user->places[0]->id]);
    }

    public function unPinEquipment($id, $equipmentId)
    {
        /* @var User $user */
        $user = User::findOrFail($id);
        $user->equipments()->syncWithoutDetaching([$equipmentId => ['to' => Carbon::today()]]);
        return redirect()->route('places.show', [$user->places[0]->id]);
    }

    public function deleteEquipment($id, $equipmentId)
    {
        /* @var User $user */
        $user = User::findOrFail($id);
        $user->equipments()->detach($equipmentId);
        return redirect()->route('places.show', [$user->places[0]->id]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index');
    }

    public function getSpecialists()
    {
        $users = User::whereHas('specialistGroups')->with('workTickets')->paginate(30);
        return view('user.index')->with('users', $users);
    }
}
