@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('groupEdit', $group) !!}
        {!! Form::model($group, ['route' => ['groups.update', $group->id], 'method' => 'PATCH']) !!}
        @include('group.form')
        <button type="submit" class="btn btn-info">Изменить</button>
        {!! Form::close() !!}
    </div>
@endsection