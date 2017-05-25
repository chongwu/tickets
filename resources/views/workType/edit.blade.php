@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('workTypeEdit', $workType) !!}
        {!! Form::model($workType, ['route' => ['work-types.update', $workType->id], 'method' => 'PATCH']) !!}
        @include('workType.form')
        <button type="submit" class="btn btn-info">Изменить</button>
        {!! Form::close() !!}
    </div>
@endsection