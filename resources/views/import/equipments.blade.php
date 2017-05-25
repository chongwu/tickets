@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Form::open(['route' => 'import.storeEquipments', 'files' => true]) !!}
        <div class="form-group{{$errors->has('equipments') ? ' has-error' : ''}}">
            {{ Form::label('equipments', 'Список оборудования') }}
            {!! Form::file('equipments', ['class' => 'form-control', 'placeholder' => 'Выберите файл', 'required']) !!}
            @if ($errors->has('equipments'))
                {{ Html::tag('span', Html::tag('strong', $errors->first('equipments'))->toHtml(),['class' => 'help-block']) }}
            @endif
        </div>
        {!! Form::submit('Загрузить', ['class' => 'btn btn-info']) !!}
        {!! Form::close() !!}
    </div>
@endsection