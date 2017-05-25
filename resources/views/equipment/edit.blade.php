@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('equipmentEdit', $equipment) !!}
        {!! Form::model($equipment, ['route' => ['equipments.update', $equipment->id], 'method' => 'PATCH']) !!}
        @include('equipment.form')
        <button type="submit" class="btn btn-info">Изменить</button>
        {!! Form::close() !!}
    </div>
@endsection