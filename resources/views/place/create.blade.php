@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('placeCreate') !!}
        {!! Form::open(['route' => 'places.store']) !!}
            @include('place.form')
            <button type="submit" class="btn btn-info">Добавить</button>
        {!! Form::close() !!}
    </div>
@endsection