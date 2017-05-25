@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Группы специалистов</h3>
        <div class="margin-top-10 margin-bottom-10">
            {{ Html::link(route('groups.create'), 'Добавить группу', ['class' => 'btn btn-info']) }}
        </div>
        @if($groups->count() > 0)
            <table class="table table-bordered table-hovertable-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th>Специалисты</th>
                        <th>Список выполняемых работ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->users->implode('name', ', ') }}</td>
                        <td>{{ $group->workTypes->implode('name', ', ') }}</td>
                        <td>
                            <a href="{{route('groups.edit', [$group->id])}}" class="btn btn-info btn-xs" title="Редактировать">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            {!! Form::open(['route' => ['groups.destroy', $group->id], 'method' => 'delete', 'class' => 'display-inline']) !!}
                            {{ Form::button('<i class="fa fa-times" aria-hidden="true"></i>', ['type' => 'submit','class' => 'btn btn-danger btn-xs', 'title' => 'Удалить']) }}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Не добавлено ни одной группы!</p>
        @endif
    </div>
@endsection