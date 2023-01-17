@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $user \app\Models\User */
@endphp


@extends('adminwinda::screen')




@section('content')
    <h3>Выбрать из списка и отредактировать</h3>
    <h1>
        Поиск пользователей
    </h1>
<p>Чтобы использовать элемент управления для выполнения поиска, а не как инструмент для ввода данных, выберите вариант Поиск записи в форме на основе значения</p>

    <table class="table  bg-white">
        <tr>
            <td>ИД</td>
            <td>Имя</td>
            <td>Character Игрок</td>
            <td>VK</td>
            <td>tg id</td>
            <td>Создан</td>
        </tr>

        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>

                <td>
                    <a href="{{route("admin.user.show", $user)}}">
                        {{$user->name}}
                    </a>
                </td>

                <td>
                    <a href="{{route("admin.character.show", $user->player ?? 0)}}">
                        {{$user->player->name ?? $user->player->baseName ?? "N/A"}} #{{$user->player->id ?? "N/A"}}
                    </a>
                </td>

                <td>
                    <a href="{{route("admin.user.history", $user->id)}}">
                        История сообщений
                    </a>
                </td>

                <td>
                    <a href="https://vk.com/id{{$user->vk_id ?? 0}}">
                        vk.com/id{{$user->vk_id ?? 0}}
                    </a>
                </td>


                <td>
                    {{$user->tg_id ?? "NA"}}
                </td>
                <td>
                    {{$user->created_at }}
                </td>

            </tr>
        @endforeach
    </table>

@endsection

