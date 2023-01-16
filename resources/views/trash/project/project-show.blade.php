@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $project \app\Models\Trash\Project */
@endphp


@extends('layouts.containerscreen')




@section('content')

    <h1>Проект {{$project->name}}</h1>


    <a href="{{route("editor.show", $project)}}">Editor</a>

@endsection

