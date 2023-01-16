@foreach($buttons ?? [] as $button=>$col)

        <a oncontextmenu="console.log(11);   window.open('/api/messagebox/send?onlytext=1&text={{$button}}', '_blank').focus();   return false;" class="   col-4 m-1 p-2 btn btn-secondary" style="max-width: 31%;" onclick="Messagebox.Sendmessage('{{$button}}');">{{$button}}</a>

@endforeach

