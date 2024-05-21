@extends('layouts/layout')

@section('content') 
    <main>
        <p>Всего городов: {{ count($cities) }}</p>
        @foreach ($cities as $city)
            <a href="/{{ $city->slug }}" class="{{ session('selectedCitySlug') == $city->slug ? 'fw-bold' : '' }}">{{ $city->name }}</a>
        @endforeach
    </main>
@endsection

@section('custom-js')

@endsection
