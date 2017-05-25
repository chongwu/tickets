@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('groupCreate') !!}
        {!! Form::open(['route' => 'groups.store']) !!}
        @include('group.form')
        <button type="submit" class="btn btn-info">Добавить</button>
        {!! Form::close() !!}
    </div>
@endsection