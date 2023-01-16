<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->

    <select class="form-select" aria-label="Default select example">
        {{$currentOption}}

        @foreach($options as $key=>$val)
            <option value="{{$key}}"
                    @if($currentOption==$key)
                    selected
                    @endif
            > {{$val}} </option>
        @endforeach

    </select>

</div>