@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $categorys \App\Models\Bot\ItemCharacterShop[] */
@endphp


@extends('admin.screen')




@section('content')

    <h1>Категории</h1>


    @foreach($categorys as $item)

        <BR><BR> <a href="{{route("admin.itemshop.showCategory", basename(get_class($item)))}}"> {{$item->icon}} {{$item->baseName}} {{basename( get_class($item))}} </a>
    @endforeach

@endsection

