@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Кабинеты</h3>
        @if($places->count() > 0)
            <div class="list-group">
                @foreach($places as $place)
            	    <a href="{{route('places.show', [$place->id])}}" class="list-group-item">{{$place->place}}</a>
                @endforeach
            </div>
        @else
            <p>Ни одного кабинета не добавлено!</p>
        @endif
        {{ Html::link(route('places.create'), 'Добавить кабинет', ['class' => 'btn btn-info']) }}
    </div>
@endsection