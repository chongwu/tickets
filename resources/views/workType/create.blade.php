@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('workTypeCreate') !!}
        {!! Form::open(['route' => 'work-types.store']) !!}
        @include('workType.form')
        <button type="submit" class="btn btn-info">Добавить</button>
        {!! Form::close() !!}
    </div>
@endsection