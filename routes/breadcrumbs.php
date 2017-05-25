<?php

Breadcrumbs::register('home', function ($breadcrumbs){
    $breadcrumbs->push('Главная', route('home'));
});

Breadcrumbs::register('ticket', function ($breadcrumbs, $ticket){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Заявка #'.$ticket->id, route('tickets.show', $ticket->id));
});

Breadcrumbs::register('ticketCreate', function ($breadcrumbs){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Новая заявка', route('tickets.create'));
});

Breadcrumbs::register('equipmentTypes', function ($breadcrumbs){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Типы оборудования', route('equipment-types'));
});

Breadcrumbs::register('equipmentType', function ($breadcrumbs, $equipmentType){
    $breadcrumbs->parent('equipmentTypes');
    $breadcrumbs->push($equipmentType->name, route('equipment-types.show', $equipmentType->id));
});

Breadcrumbs::register('equipment', function ($breadcrumbs, \App\Equipment $equipment){
    $breadcrumbs->parent('equipmentType', $equipment->equipmentType);
    $breadcrumbs->push($equipment->name, route('equipments.show', $equipment->id));
});

Breadcrumbs::register('equipmentCreate', function ($breadcrumbs){
    $equipmentType = \App\EquipmentType::findOrFail(Request::segment(3));
    $breadcrumbs->parent('equipmentType', $equipmentType);
    $breadcrumbs->push('Новое оборудование', route('equipments.create'));
});

Breadcrumbs::register('equipmentEdit', function ($breadcrumbs, \App\Equipment $equipment){
    $breadcrumbs->parent('equipment', $equipment);
    $breadcrumbs->push('Редактирование', route('equipments.edit', $equipment->id));
});

Breadcrumbs::register('places', function ($breadcrumbs){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Кабинеты', route('places.index'));
});

Breadcrumbs::register('placeCreate', function ($breadcrumbs){
    $breadcrumbs->parent('places');
    $breadcrumbs->push('Новый кабинет', route('places.create'));
});

Breadcrumbs::register('place', function ($breadcrumbs, \App\Place $place){
    $breadcrumbs->parent('places');
    $breadcrumbs->push($place->place, route('places.show', $place->id));
});

Breadcrumbs::register('placeEdit', function ($breadcrumbs, \App\Place $place){
    $breadcrumbs->parent('place', $place);
    $breadcrumbs->push('Редактирование', route('places.edit', $place->id));
});

Breadcrumbs::register('placeAddUsers', function ($breadcrumbs, $placeId){
    $place = \App\Place::findOrFail($placeId);
    $breadcrumbs->parent('place', $place);
    $breadcrumbs->push('Закрепление сотрудников', route('places.addUsers', $place->id));
});

Breadcrumbs::register('placeAddEquipments', function ($breadcrumbs, $placeId){
    $place = \App\Place::findOrFail($placeId);
    $breadcrumbs->parent('place', $place);
    $breadcrumbs->push('Закрепление оборудования', route('places.addEquipments', $place->id));
});

Breadcrumbs::register('users', function ($breadcrumbs){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Сотрудники', route('users.index'));
});

Breadcrumbs::register('user', function ($breadcrumbs, \App\User $user){
    if($user->places->count() > 0){
        $breadcrumbs->parent('place', $user->places[0]);
    }
    else{
//        $breadcrumbs->parent('home');
    }
    $breadcrumbs->push($user->name, route('users.show', [$user->id]));
});

Breadcrumbs::register('userEdit', function ($breadcrumbs, \App\User $user){
    $breadcrumbs->parent('user', $user);
    $breadcrumbs->push('Редактирование', route('users.edit', $user->id));
});

Breadcrumbs::register('userAddEquipment', function ($breadcrumbs, $userId){
    $user = \App\User::findOrFail($userId);
    $breadcrumbs->parent('user', $user);
    $breadcrumbs->push('Закрепление оборудование', route('users.addEquipment', $user->id));
});

Breadcrumbs::register('groups', function ($breadcrumbs){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Группы специлистов', route('groups.index'));
});

Breadcrumbs::register('groupCreate', function ($breadcrumbs){
    $breadcrumbs->parent('groups');
    $breadcrumbs->push('Новая группа', route('groups.create'));
});

Breadcrumbs::register('groupEdit', function ($breadcrumbs, \App\SpecialistGroup $group){
    $breadcrumbs->parent('groups');
    $breadcrumbs->push($group->name.' - редактирование', route('groups.edit', $group->id));
});

Breadcrumbs::register('workTypes', function ($breadcrumbs){
//    $breadcrumbs->parent('home');
    $breadcrumbs->push('Типы работ', route('work-types.index'));
});

Breadcrumbs::register('workTypeCreate', function ($breadcrumbs){
    $breadcrumbs->parent('workTypes');
    $breadcrumbs->push('Новый тип работы', route('work-types.create'));
});

Breadcrumbs::register('workTypeEdit', function ($breadcrumbs, \App\WorkType $workType){
    $breadcrumbs->parent('workTypes');
    $breadcrumbs->push($workType->name.' - редактирование', route('work-types.edit', $workType->id));
});