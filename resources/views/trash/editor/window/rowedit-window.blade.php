<div class="card windowEditor windowBaseRow">
    <div class="card-body pb-2 pt-3">
        <h6>Редактор секции</h6>
    </div>

    <div class="card-body">
        <h6>Фон </h6>
        <small>Управление фоном </small>

        <label> Url background
            <input class="form-control " id="inp_backgroundUrl">
        </label>

        <label> Цвет заполнения
            <BR>
            <input class="form-control-color" type="color" id="inp_overlayColor">
        </label>

        <label> Заполнение оверлей
            <input class="form-range" type="range" id="inp_overlayOpacity" max="100" min="0">
        </label>
    </div>

    <div class="card-body">
        <h6>Текст</h6>
        <label> Цвет текста
            <BR>
            <input class="form-control-color" type="color" id="inp_textColor">
        </label>
    </div>

    <div class="card-body">
        <h6>Размеры</h6>
        <label> Вертикальный отступ
            <input class="form-range" type="range" id="inp_paddingVertical" max="400" min="0">
        </label>
    </div>

    <div class="card-body">
        <a class="btn btn-outline-dark btn-sm float-end btnSave">Сохранить</a>
        <a class="btn btn-outline- btn-sm float-end btnClose">Отменить</a>
    </div>

</div>
