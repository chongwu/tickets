@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Типы работ</h3>
        <div class="margin-top-10 margin-bottom-10">
            {{ Html::link(route('work-types.create'), 'Добавить тип работы', ['class' => 'btn btn-info']) }}
        </div>
        @if($workTypes->count() > 0)
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th>Тип оборудования</th>
                        <th>Кол-во рабочих дней</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($workTypes as $workType)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $workType->name }}</td>
                        <td>{{ empty($workType->equipmentType)?'':$workType->equipmentType->name }}</td>
                        <td>{{ $workType->days }}</td>
                        <td>
                            <a href="{{route('work-types.edit', [$workType->id])}}" class="btn btn-info btn-xs" title="Редактировать">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            {!! Form::open(['route' => ['work-types.destroy', $workType->id], 'method' => 'delete', 'class' => 'display-inline']) !!}
                            {{ Form::button('<i class="fa fa-times" aria-hidden="true"></i>', ['type' => 'submit','class' => 'btn btn-danger btn-xs', 'title' => 'Удалить']) }}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else
            <p>Не добавлено ни одного типа работ!</p>
        @endif
    </div>
@endsection