@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('place', $place) !!}
        <h3>
            {{ $place->place }}
            @include('partials._modelButtons', ['model' => $place])
        </h3>
        <div class="margin-bottom-10">
            {{ Html::link(route('places.addUsers', [$place->id]), 'Закрепить сотрудников', ['class' => 'btn btn-info']) }}
            {{ Html::link(route('places.addEquipments', [$place->id]), 'Закрепить оборудование', ['class' => 'btn btn-info']) }}
        </div>
        @include('user._list', ['model' => $place])
        @include('equipment._list', ['equipments' => $equipments, 'model' => $place])
    </div>
@endsection