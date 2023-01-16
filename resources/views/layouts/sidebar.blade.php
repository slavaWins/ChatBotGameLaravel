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

    .divHrefSide a {

        color: #1D1D1B;
    }

    .divHrefSide {
        line-height: 2.0em;
        font-family: 'Inter';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        color: #1D1D1B;
    }

    .spanTitle {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 500;
        font-size: 11px;
        line-height: 16px;
        /* identical to box height */
        color: #1D1D1B;
    }

</style>
<div class="col-md-4   sidebarFloatind  py-4 px-4" style="    ">
    <div class="  " style="  ">


        @yield("sidebar")

        <BR>



        <div class="card ">
            <div class="card-header">Не можете определится?</div>
            <div class="card-body">
                <p class="card-title">
                    Создайте заказ, и укажите галочку - помощь в формулировке. Бухгалтеры сами помогут сформулировать
                    ваш вопрос.
                </p>

            </div>
        </div>

    </div>
</div>
