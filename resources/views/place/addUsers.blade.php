@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('placeAddUsers', $placeId) !!}
        {!! Form::open(['route' => ['places.storeUsers', $placeId]]) !!}
            <div class="form-group">
                {{ Form::label('users[]', 'Сотрудники') }}
                {!!  Form::select('users[]', $users, null, ['class' => 'form-control users-list', 'multiple' => 'multiple']) !!}
            </div>
            <button type="submit" class="btn btn-info">Добавить</button>
        {!! Form::close() !!}
    </div>
@endsection

@section('stylesheet')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $(".users-list").select2({
            placeholder: "Выберите сотрудников",
            allowClear: true
        });
    </script>
@endsection