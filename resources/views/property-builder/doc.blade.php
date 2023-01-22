@php
    /** @var MigrationRender $fb */
    /** @var \App\Library\PropertyBuilder\PropertyBuilderStructure[] $props */

use App\Library\PropertyBuilder\MigrationRender;
@endphp



@foreach($list as $ind=> $data)

    $table @foreach( $data as $fun=> $arg)
        ->{{$fun}}({{$arg}})
    @endforeach;
@endforeach

