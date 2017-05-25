@extends('layouts.app')
@section('content')
    <div class="container">
        {!! Breadcrumbs::render('user', $user) !!}
        <h3>
            {{ $user->name }}{!! $user->isSpecialist()?' <small>(специалист)</small>':'' !!}
            @include('partials._modelButtons', ['model' => $user])
        </h3>
        @if(!$user->places->isEmpty())
            <div class="margin-top-10">
                {{ Html::link(route('users.addEquipment', [$user->id]), 'Закрепить оборудование', ['class' => 'btn btn-info btn-xs']) }}
            </div>
            @include('user._equipments', ['user' => $user])
        @endif
    </div>
@endsection