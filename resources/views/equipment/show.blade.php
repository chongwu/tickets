@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('equipment', $equipment) !!}
        <h3>
            {{$equipment->name}}
            <small># {{$equipment->inventory_number}}</small>
            @include('partials._modelButtons', ['model' => $equipment])
        </h3>
        <div class="equipment-content">{{$equipment->content}}</div>

    </div>
@endsection