@php


    /*** @var $shop \app\Models\Trash\Shop */
@endphp


@auth

    <div class="modal" id="basketClearModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Другой магазин</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    В вашей корзине товары с другого магазина. Очистить корзину?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn  btn-outline-dark" data-bs-dismiss="modal">Нет</button>
                    <a type="button" class="btn  btn-outline-danger" href="{{route("basket.api.clear")}}">Да </a>
                </div>

            </div>
        </div>
    </div>
@endauth
