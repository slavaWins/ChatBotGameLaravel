@foreach($inpList as $key=>$item)

    <div class="form-outline mb-4">


        <?php

        $val = old($key);

        if(isset($item['val'])){
            $val = $item['val'];
        }
        //created_at

        ?>


        @if($item['type']=="checkbox")

        <div class="form-check">
            <input class="form-check-input   gencheckbox_{{$key}}  @error('{{$key}}') is-invalid @enderror"
                   name="{{$key}}"
                   type="checkbox"   id="gcheck-{{$key}}"
                   @if(isset($item['wire']))
                   wire:model="{{$item['wire']}}"
                   @endif

                   @if($val)
                   checked
                   @endif

                    />
            <label class="form-check-label" for="gcheck-{{$key}}">{{$item['label']}}</label>
        </div>


            @else

        <input id="{{$key}}" type="{{$item['type']}}"
               class="form-control   @error('{{$key}}') is-invalid @enderror" name="{{$key}}"

               @if(isset($item['wire']))
               wire:model="{{$item['wire']}}"
               @endif

               value="{{ $val }}"

               @if(isset($item['required']))
               required
               @endif

               autocomplete="{{$key}}">


        <label class="form-label  " for="{{$key}}">{{$item['label']}}</label>


        @error($key)
        <div id="{{$key}}" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

            @endif

    </div>

@endforeach