<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentType;
use App\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Collections\SheetCollection;

class ImportController extends Controller
{
    public function equipments()
    {
        return view('import.equipments');
    }

    public function storeEquipments(Request $request)
    {
        /*$this->validate($request, [
            'equipments' => 'mimetypes:csv'
        ]);*/
        /* @var SheetCollection $rowsCollection */
        $rowsCollection = \Excel::load($request->file('equipments')->path())->get();
        $groupedByPlaces = $rowsCollection->groupBy('place');
        //Импорт кабинетов
        $places = $groupedByPlaces->keys()->transform(function ($el){return ['place' => $el];})->toArray();
        Place::insert($places);
        //Импорт типов оборудования
        $rootEquipmentType = EquipmentType::create(['name' => 'ПК и Оргтехника', 'folder' => true]);
        $equipmentsTypes = $rowsCollection->groupBy('equipment_type')->keys()->transform(function ($el)use($rootEquipmentType){
            return ['name' => $el, 'parent_id' => $rootEquipmentType->id];
        })->toArray();
        EquipmentType::insert($equipmentsTypes);
        //Импорт оборудования и соединение его с типами оборудования
        $dbEquipmentTypes = EquipmentType::all('id', 'name');
        $equipments = $rowsCollection->transform(function ($el)use($dbEquipmentTypes){
            return [
                'inventory_number' => $el->inventory_number,
                'name' => $el->name,
                'equipment_type_id' => $dbEquipmentTypes->where('name', '=', $el->equipment_type)->first()->id
            ];
        })->toArray();
        Equipment::insert($equipments);
        //Присоединение добавленного оборудования к существующим кабинетам
        $dbPlaces = Place::all(['id', 'place']);
        $dbEquipments = Equipment::all(['id', 'inventory_number']);
        $groupedByPlaces->each(function ($rows, $place) use($dbPlaces, $dbEquipments){
            $attachEquipments = [];
            $rows->each(function($el)use($dbEquipments, &$attachEquipments){
                $equipmentId = $dbEquipments->where('inventory_number', '=', $el->inventory_number)->first()->id;
                $attachEquipments[$equipmentId] = ['from' => Carbon::today()];
            });
            $dbPlaces->where('place', '=', $place)->first()->equipments()->attach($attachEquipments);
        });
        return redirect()->route('import.equipments');
    }
}
