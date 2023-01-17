@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $character \App\Models\Bot\Character */
@endphp


@extends('adminwinda::screen')




@section('content')

    <h1>character {{$character->baseName}} #{{$character->id}}</h1>
    <small>{{$character->className}}</small>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.character.edit', $character) }}">
                @csrf
                Параметры
                @foreach($character->GetStats() as $ind=>$stat)

                    @php

                        FElement::NewInputTextRow()
                         ->SetLabel($stat->name)
                         ->SetName($ind)
                         ->SetValue(old($ind, $stat->value))
                         ->SetDescr($ind .' ' . ($stat->descr ?? '') ." | max:" . $stat->max ?? "NOLIMIT")
                         ->RenderHtml(true);
                    @endphp

                @endforeach

                <button type="submit" class="btn btn-outline-dark float-end">Сохранить изменения</button>

            </form>
        </div>
    </div>

@endsection

