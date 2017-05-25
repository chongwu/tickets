@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Список организаций</h3>
        @forelse($organizations as $organization)
            <p>{{ $organization->name }}</p>
        @empty
            <p>Не добавлено ни одной организации</p>
        @endforelse
    </div>
@endsection