@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $userShow \app\Models\User */
   /*** @var $character \App\Models\Bot\Character */
@endphp


@extends('adminwinda::screen')




@section('content')

    <h1>User {{$userShow->name ?? $userShow->player->name ?? "NA"}} #{{$userShow->id}}</h1>


    <div class="card">
        <div class="card-body">
            <h4>Чары игрока</h4>
            <table class="table  bg-white">
                <tr>
                    <td>ИД</td>
                    <td>Имя</td>
                    <td>Статки</td>
                </tr>
                @foreach($userShow->GetAllCharacters() as $character)
                    <tr>
                        <td>{{$character->id}}</td>

                        <td>
                            <a href="{{route("admin.character.show", $character)}}">
                                {{$character->icon}} {{$character->baseName}} - {{$character->name ?? "NA"}}
                            </a>
                        </td>

                        <td>
                            {{$character->RenderStats(true, false, true)}}
                        </td>

                        <td>

                        </td>

                    </tr>
                @endforeach

            </table>

        </div>
    </div>

@endsection

