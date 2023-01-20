@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $user \app\Models\User */
   /*** @var $character \App\Models\Bot\Character */
@endphp


<div class="col-8">
    <div class="card">
        <div class="card-body">
            <h4>Чары игрока</h4>
            <table class="table  bg-white">
                <tr>
                    <td>ИД</td>
                    <td>ParentId</td>
                    <td>Имя</td>
                    <td>Статки</td>
                </tr>
                @foreach($user->GetAllCharacters() as $character)
                    <tr>
                        <td>{{$character->id}}</td>
                        <td>{{$character->parent_id}}</td>

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

</div>
