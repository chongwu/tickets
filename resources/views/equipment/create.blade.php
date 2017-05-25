@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('equipmentCreate') !!}
        {!! Form::open(['route' => 'equipments.store']) !!}
            @include('equipment.form')
            <button type="submit" class="btn btn-info">Добавить</button>
        {!! Form::close() !!}
    </div>
@endsection