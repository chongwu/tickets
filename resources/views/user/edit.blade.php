@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('userEdit', $user) !!}
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PATCH']) !!}
        <legend>Telegram ID пользователя {{ $user->name }}</legend>
        <div class="form-group{{$errors->has('telegram_id') ? ' has-error' : ''}}">
            {{ Form::label('telegram_id', 'Telegram ID') }}
            {{ Form::text('telegram_id', null, ['class' => 'form-control', 'placeholder' => 'Telegram ID']) }}
            @if ($errors->has('telegram_id'))
                {{ Html::tag('span', Html::tag('strong', $errors->first('telegram_id'))->toHtml(),['class' => 'help-block']) }}
            @endif
        </div>
        <button type="submit" class="btn btn-info">Изменить</button>
        {!! Form::close() !!}
    </div>
@endsection