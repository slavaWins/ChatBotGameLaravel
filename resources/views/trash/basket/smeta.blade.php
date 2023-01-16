
    <div class="row basketSmetaRow  mb-1">
        <div class="col-auto ">
            <img src="/img/icon_deliv.png">
        </div>
        <div class="col  p-0">Доставка</div>
        <div class="col _priceCol">{{number_format($amount_delivery, 2)}} ₽</div>
    </div>

    <div class="row basketSmetaRow mb-1 ">
        <div class="col-auto ">
            <img src="/img/icon_prod.png">
        </div>
        <div class="col  p-0">Продукты</div>
        <div class="col _priceCol">{{number_format($amount_products, 2)}} ₽</div>
    </div>

    <div class="row basketSmetaRow mb-1 ">
        <div class="col-auto ">
            <img src="/img/icon_service.png">
        </div>
        <div class="col  p-0">Услуги сервиса</div>
        <div class="col _priceCol">{{number_format($amount_service, 2)}} ₽</div>
    </div>


    <div class="row  mb-1" style="font-size: 14px;">
        <div class="col   ">Итого</div>
        <div class="col" style="text-align: right;">{{number_format($amount_all, 2)}} ₽</div>
    </div>

