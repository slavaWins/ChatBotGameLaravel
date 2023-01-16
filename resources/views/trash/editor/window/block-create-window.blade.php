<style>
    .windowBlockCreate {
        position: fixed;
        top: 20%;
        left: 50%;
    }
</style>
<div class="card windowEditor windowBlockCreate">
    <div class="card-body pb-2 pt-3">
        <h6>Создание блока</h6>
    </div>

    <div class="card-body">
        <h6 class="mb-0">Текстовые </h6>
        <small>Управление фоном </small>

        <BR>

        <a class="btn btn-outline-dark" onclick="WindowEditorController.windowBlockCreate.Select('h1');">Заголовок</a>
        <a class="btn btn-outline-dark" onclick="WindowEditorController.windowBlockCreate.Select('p');">Текст</a>
        <a class="btn btn-outline-dark" onclick="WindowEditorController.windowBlockCreate.Select('btn');">Кнопка</a>

    </div>


    <div class="card-body">
        <a class="btn btn-outline- btn-sm float-end btnClose">Отменить</a>
    </div>

</div>
