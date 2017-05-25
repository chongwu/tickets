@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Типы оборудования</h3>
        @include('equipmentType.form')

        <div class="list-group equipment-types">
            @if($equipmentTypes->count() > 0)
                @foreach($equipmentTypes as $equipmentType)
                    @include('equipmentType._list_item', ['equipmentType' => $equipmentType])
                @endforeach
            @else
                <p id="empty-types">Не добавлено ни одного типа оборудования</p>
            @endif
        </div>

    </div>
@endsection

@section('stylesheet')
    @parent
    <link href="/css/sweetalert.css" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="/js/sweetalert.min.js"></script>
    <script src="/js/equipment-type.js"></script>
@endsection