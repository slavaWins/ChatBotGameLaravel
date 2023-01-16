@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $project \app\Models\Trash\Project */
   /*** @var $baserow \app\Models\Trash\BaseRow */
@endphp


@extends('trash.editor.layout')

@section('content')

    <script>

    </script>

    <style>
        .baseRow {
            background-size: cover !important;
            position: relative;
            padding-top: 120px;
            padding-bottom: 120px;
        }


        .backoverlay {
            background: rgba(0, 0, 0, 0.7);
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
        }

        h1 {
            color: inherit !important;
            font-size: 55px;
            font-weight: 500;
        }

        .editor_row_panel .btn-icon:hover {
            background: #0027ff;
        }

        .editor_row_panel .btn-icon {
            box-shadow: none;
            padding: 0px 6px;
            padding-top: 2px;
            padding-bottom: 4px;
            border-radius: 22%;
        }

        .editor_row_panel .btn {
            color: #fff;
            border-color: #fff;
        }

        .editor_row_panel {
            position: absolute;
            right: 30px;
            top: 30px;
            color: #fff;
            background: rgba(0, 0, 0, 0.56);
            xborder: 1px solid #dde0e3;
            border-radius: 20px;
            padding: 10px 15px;
            display: none;

        }

        .baseRow:hover > .addingRowBtn_Bottom {
            display: block;
        }

        .baseRow:hover > .addingRowBtn_Top {
            display: block;
        }

        .baseRow:hover > .editor_row_panel {
            display: block;
        }

        .inherit_full {
            color: inherit !important;
            font-weight: inherit !important;
            font-size: inherit !important;
            text-align: inherit !important;
        }

        .textarea_simple_text {
            background: transparent;
            border: none !important;
            outline: none !important;
            width: 100%;
            height: auto;
            padding: 0px;
            overflow: hidden;
            resize: none;
        }

        .blockDiv {

        }

        .blockDiv:hover {
            background: rgba(221, 224, 227, 0.16);
        }


        .content-border {
            border: 2px solid transparent;
            padding-top: 8px;
            padding-bottom: 8px;
            position: relative;
            min-height: 85px;
        }

        .content-border:hover > .addingRowBtn_Left {
            display: block;
        }

        .content-border:hover > .addingRowBtn_Right {
            display: block;
        }

        .content-border:hover {
            border: 2px solid #0a53be;
            transition: 0.1s;
        }

        .addingRowBtn {
            background: #0a53be;
            color: #fff;
            height: 40px;
            width: 40px;
            padding: 2px;
            font-size: 22px;
            font-weight: 600;
            position: absolute;
            border-radius: 100%;
            cursor: pointer;
            z-index: 10;
            text-align: center;
        }

        .addingRowBtn_Left {
            position: absolute;
            left: -20px;
            top: 30%;
            display: none;
        }

        .addingRowBtn_Right {
            position: absolute;
            right: -20px;
            top: 30%;
            display: none;
        }

        .addingRowBtn_Bottom {
            position: absolute;
            left: calc(50% - 20px);
            bottom: -20px;
            display: none;
        }

        .addingRowBtn_Top {
            position: absolute;
            left: 50%;
            top: -20px;
            display: none;
        }

        .addingRowBtn:hover {
            background: #0065fd;
            color: #fff;
            transition: 0.25s;
        }

        .textarea_simple_text:focus {
            background: transparent;
        }

        body {
            padding-bottom: 100px;
        }

        .btnAddingFirstBlock {
            display: block !important;
            position: static !important;
        }
    </style>

    @include('trash.editor.navbar')

    @foreach($baserows as $baserow)
        <div class="baseRow baseRow_{{$baserow->id}}"
             style="background: url('{{$baserow->backgroundUrl}}') center; color: {{$baserow->textColor}}; padding-top: {{$baserow->paddingVertical}}px; padding-bottom: {{$baserow->paddingVertical}}px;"
             paddingVertical="{{$baserow->paddingVertical}}"
             overlayOpacity="{{$baserow->overlayOpacity}}"
             overlayColor="{{$baserow->overlayColor}}"
             textColor="{{$baserow->textColor}}"
             backgroundUrl="{{$baserow->backgroundUrl}}"
             baseRowId="{{$baserow->id}}"
             pos="{{$baserow->pos}}">

            <div class="backoverlay backoverlay-p "
                 style="background:{{$baserow->overlayColor}}; opacity: {{$baserow->overlayOpacity/100}};"></div>

            <div class="editor_row_panel">
                <a class="btn btn-outline-dark btn-sm ">Правки</a>

                <a class="btn btn-icon   btn-sm  btnBaseRowColor">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"
                              fill="white"/>
                    </svg>
                </a>

                <a class="btn btn-icon  btn-sm btnBaseRowDelete">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
                              fill="white"/>
                    </svg>
                </a>
            </div>

            <div class="container" style="text-align: center;">
                <div class="content-border" baseRowId="{{$baserow->id}}">
                    <div class="addingRowBtn addingRowBtn_Right  " baserow_id="{{$baserow->id}}">+</div>
                    <div class="addingRowBtn addingRowBtn_Left  " baserow_id="{{$baserow->id}}">M</div>

                    @foreach($baserow->GetBlocks() as $block)
                        <div class="blockDiv"
                             baseRowId="{{$baserow->id}}"
                             pos="{{$block->pos}}"
                             blockId="{{$block->id}}">
                            @include("blocks.".$block->template_ind,['text'=>$block->txt])
                        </div>
                    @endforeach


                </div>
            </div>

            <div class="addingRowBtn addingRowBtn_Vertical addingRowBtn_Bottom" posType="bottom">+</div>
            <div class="addingRowBtn addingRowBtn_Vertical addingRowBtn_Top" posType="top">+</div>
        </div>
    @endforeach


    <div class="row justify-content-center p-5">
        <div class="col">
            <div class="addingRowBtn addingRowBtn_Last ">+</div>
        </div>
        <div class="col">Добавить блок</div>
    </div>


    <div style="display: none">
        <PROJECT_ID>{{$project->id}}</PROJECT_ID>
    </div>


    @include("trash.editor.window.base-window")
    @include("trash.editor.window.rowedit-window")
    @include("trash.editor.window.block-create-window")

@endsection


