<style>
    .textDotLimiter {
        display: inline-block;
        width: 180px;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }

    .sidebarFloatind {
        margin-bottom: 25px;
        background: #F4F3F7;
    }

    @media (min-width: 1200px) {
        .sidebarFloatind {
            max-width: 270px;
        }
    }


</style>
<div class="col-md-4   sidebarFloatind  py-4 px-4" style="    ">
    <div class="  " style="  ">


        @yield("sidebar")

        <BR>


        <div class="col-12 p-4">
            <div class="card p-2 ">
                <div class="card-header">Не можете определится?</div>
                <div class="card-body">
                    <p class="card-title">
                        Создайте заказ, и укажите галочку - помощь в формулировке. Бухгалтеры сами помогут
                        сформулировать
                        ваш вопрос.
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
