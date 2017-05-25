@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('ticketCreate') !!}
        {!! Form::open(['route' => 'tickets.store']) !!}
        <legend>Новая заявка</legend>
        <div class="form-group{{$errors->has('work_type_id') ? ' has-error' : ''}}">
            {{ Form::label('work_type_id', 'Тип работы') }}
            {{ Form::select('work_type_id', \App\WorkType::all(['id', 'name'])->pluck('name', 'id'), isset($equipmentType)?$equipmentType:null, ['class' => 'form-control', 'placeholder' => 'Выберите тип', 'required']) }}
            @if ($errors->has('work_type_id'))
                {{ Html::tag('span', Html::tag('strong', $errors->first('work_type_id'))->toHtml(),['class' => 'help-block']) }}
            @endif
        </div>
        <algolia-search attribute="text" name="Заявка"></algolia-search>
        <div class="form-group{{$errors->has('track') ? ' has-error' : ''}}">
            {{ Form::label('track', 'Отслеживать заявку', ['class' => 'hover-label']) }}
            {{ Form::checkbox('track', null, (isset($ticket))?$ticket->track:true) }}
            @if ($errors->has('track'))
                {{ Html::tag('span', Html::tag('strong', $errors->first('track'))->toHtml(),['class' => 'help-block']) }}
            @endif
        </div>
        <button type="submit" class="btn btn-info">Отправить заявку</button>
        {!! Form::close() !!}
    </div>
@endsection