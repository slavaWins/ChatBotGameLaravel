@php
    /** @var \App\Models\Bot\History $model */
@endphp

@extends('layouts.fullscreen')

@section('content')

    <h1>пример</h1>


    <form method="POST" action="{{ route('property-builder.story') }}">
        @csrf
        {{  $model->BuildInputAll('test')}}
        <button type="submit" class="mt-4 btn btn-primary col-12 p-3 shadow-0 btn-submit-auth">
            Вход
        </button>
    </form>
@endsection

