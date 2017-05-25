@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('equipmentType', $equipmentType) !!}
        <h3>{{$equipmentType->name}}</h3>
        @if($equipmentType->folder)
            <h4>Типы оборудования</h4>
            @if($equipmentType->childTypes->count() > 0)
                <ul>
                    @foreach($equipmentType->childTypes as $type)
                        <li>{{Html::link(route('equipment-types.show', [$type->id]), $type->name)}}</li>
                    @endforeach
                </ul>
            @else
                <p>Типы оборудования не добавлены</p>
            @endif
        @endif
        <h4>Оборудование:</h4>
        @if($equipmentType->equipments->count() > 0)
            <div class="list-group">
                @foreach($equipmentType->equipments as $equipment)
            	    <a href="{{route('equipments.show', $equipment->id)}}" class="list-group-item">
                        {{$equipment->name}}
                    </a>
                @endforeach
            </div>
        @else
            <p>Оборудование не добавлено</p>
        @endif
        <div>{{ Html::link(route('equipments.createFor', $equipmentType->id), 'Добавить оборудование', ['class' => 'btn btn-info']) }}</div>
    </div>
@endsection