@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::user()->isHeader() && Request::route()->getName() === 'users.specialists')
            <h3>Специалисты</h3>
            @if($users->count() > 0)
                <table class="table table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ф.И.О.</th>
                            <th>Количество выполняемых заявок</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Html::link(route('users.show', [$user->id]), $user->name) }}</td>
                            <td>{{ $user->workTickets->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <h3>Сотрудники</h3>
            <div class="list-group">
                @foreach($users as $user)
                    <a href="{{ route('users.show', [$user->id]) }}" class="list-group-item">{{ $user->name }}</a>
                @endforeach
            </div>
        @endif

        {{ $users->links() }}
    </div>
@endsection