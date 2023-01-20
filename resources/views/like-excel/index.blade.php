@extends('adminwinda::screen')




@section('content')
    <script src="{{ asset('js/likeexcel/core.js')."?".microtime()  }}"></script>

    <h1>Эксель типа</h1>
    <h2>Управление и разработка</h2>
    <p>
        Панель управления - это простой и понятный инструмент для выполнения повседневных задач контент-менеджера. От
        простого редактирования информации до управления разделами проекта.</p>

    <style>
        .likeExcelTable ._input, .likeExcelTable ._val {
            padding: 0px 3px;
            display: block;
            border: none;
            width: 100%;
            background: transparent;
            border-radius: 0px;
            outline: none !important;

        }

        .likeExcelTable td {
            padding: 0px;
            font-family: Calibri;
            font-size: 11pt;
            font-weight: 500;
            color: #000;
        }

        ._tdchanged {
            background: #ecdcdc !important;
        }

        ._cursor {
            outline: thick solid #227522;
            outline-width: 2px;
        }

        .table-bordered > :not(caption) > * > * {
            border: 1px solid #d7d7d7;
        }
    </style>


    <div class="likeExcelTableWidnow">
        <a class="btn btn-primary disabled le_btn_save">Сохранить имзенения</a>
    </div>
    <table class="table table-bordered likeExcelTable">
        <tr>
            @foreach($colums as $colum_ind => $colum_data)
                <td>{{$colum_ind}} <BR> {{$colum_data['name']}} </td>
            @endforeach
        </tr>

        @foreach($data as $K => $V)
            <tr class="tr-body " rowId="{{$K}}">
                @foreach($colums as $colum_ind => $colum_data)
                    <td
                        @if($colum_data['type']=="select")
                            options="{{json_encode($colum_data['options'])}}"
                        @endif
                        tdType="{{$colum_data['type']}}"
                        tdInd="{{$colum_ind}}"
                        parentId="{{$K}}" class=" ">
                        <div class="_val">
                            @if($colum_data['type']=="select")
                                {{$colum_data['options'][ $V[$colum_ind]??0 ]??0}}
                            @else
                                {{$V[$colum_ind]??0}}
                            @endif

                        </div>
                        <div class="_edit input-group"></div>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

@endsection

