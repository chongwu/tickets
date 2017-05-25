@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Отчет</h1>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::open(['route' => 'report.get', 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('year', 'Год') }}
                {{ Form::input('number', 'year', date('Y'), ['class' => 'form-control', 'placeholder' => 'Год', 'min' => '2016', 'max' => '2100', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('month', 'Месяц') }}
                {{ Form::selectMonth('month', date('n'), ['class' => 'form-control']) }}
            </div>
            {!! Form::button('Сгенерировать отчет', ['type' => 'submit', 'class' => 'btn btn-info']) !!}
        {!! Form::close() !!}
    </div>
@endsection