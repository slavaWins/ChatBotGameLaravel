@php

    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $shop \app\Models\Trash\Shop */
@endphp


@auth
    <BR>
    <small class=" ">
        <a class="text-danger  " data-bs-toggle="modal" data-bs-target="#myModal"
           href="#">Пожаловаться</a>
    </small>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Жалоба</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    @php
                        FElement::NewInputText()
                         ->SetLabel("Суть жалобы")
                         ->SetName("descr")
                         ->FrontendValidate()->String(4,75)
                         ->SetValue(old("descr") ?: "")
                         ->SetDescr("Опишите проблему")
                         ->RenderHtml(true);
                    @endphp

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn  btn-outline-dark" data-bs-dismiss="modal">Close
                    </button>
                </div>

            </div>
        </div>
    </div>
@endauth
