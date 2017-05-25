@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('placeEdit', $place) !!}
        {!! Form::model($place, ['route' => ['places.update', $place->id], 'method' => 'PATCH']) !!}
        @include('place.form')
        <button type="submit" class="btn btn-info">Изменить</button>
        {!! Form::close() !!}
    </div>
@endsection