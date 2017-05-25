@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('placeAddEquipments', $placeId) !!}
        {!! Form::open(['route' => ['places.storeEquipments', $placeId]]) !!}
            <div class="form-group">
                {{ Form::label('equipments[]', 'Оборудование') }}
                {!!  Form::select('equipments[]', $equipments, null, ['class' => 'form-control equipments-list', 'multiple' => 'multiple']) !!}
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
        $(".equipments-list").select2({
            placeholder: "Выберите оборудование",
            allowClear: true,
            language: {
                noResults: function (params) {
                    return "Нет доступного оборудования.";
                }
            }
        });
    </script>
@endsection