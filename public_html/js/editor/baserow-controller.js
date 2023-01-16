var BaseRowController = {};

BaseRowController.currentOption = {
    project_id: 0,
    baseRowId: 0,
    posAfter: 0,
    posType: "bottom",//добавить снизу или сверху
    pos: 0, //позициая сортировки
};


BaseRowController.AddBaseRow = function (baseRowId, posType) {

    BaseRowController.currentOption.baseRowId = baseRowId;
    BaseRowController.currentOption.posType = posType;

    BaseRowController.currentOption.pos = parseInt($('.baseRow_' + baseRowId).attr("pos") ?? 0);

    if (posType == "bottom") {
        BaseRowController.currentOption.pos += 10;
    } else {
        BaseRowController.currentOption.pos -= 10;
    }


    EasyApi.Post('/api/editor/add_baserow', BaseRowController.currentOption, function (response, error) {
        if (error) {
            return;
        }
        location.reload();
    });
}


BaseRowController.Init = function () {
    BaseRowController.currentOption.project_id = $('PROJECT_ID').text();

    $('.addingRowBtn_Last').on("click", function () {
        BaseRowController.AddBaseRow(
            1,
            'bottom',
        );
    })

    $(".baseRow").each(function (e) {

        var baseRow = $(this);
        BaseRowController.NewBaseRow(baseRow);
    });




}

BaseRowController.baseRows = {};

BaseRowController.NewBaseRow = function (baseRow) {
    var self = {};


    self.e = baseRow;
    self.id = parseInt(baseRow.attr('baseRowId'));

    self.parameters = {};
    self.parameters.backgroundUrl = baseRow.attr('backgroundUrl');
    self.parameters.overlayOpacity = baseRow.attr('overlayOpacity');
    self.parameters.paddingVertical = baseRow.attr('paddingVertical');
    self.parameters.textColor = baseRow.attr('textColor');
    self.parameters.overlayColor = baseRow.attr('overlayColor');

    if (BaseRowController.baseRows[self.id]) return;
    BaseRowController.baseRows[self.id] = self;




    baseRow.find(".btnBaseRowColor").on("click", function () {
        BaseRowController.currentOption.baseRowId = self.id;
        WindowEditorController.ToPos('.windowBaseRow', $(this));
        WindowEditorController.windowEditorSection.LoadByRowId(self.id);
    });

    baseRow.find(".btnBaseRowDelete").on("click", function () {
        BaseRowController.currentOption.baseRowId = self.id;
        EasyApi.Post('/api/editor/remove_baserow', BaseRowController.currentOption, function (response, error) {
            if (error) return;
            BaseRowController.baseRows[self.id] = null;
            self = null;
            baseRow.remove();
        });
    });

    baseRow.find(".addingRowBtn_Content").each(function (e) {
        $(this).on("click", function () {
            BaseRowController.AddElementConenent(
                self.id,
                100,
            );
        })
    });

    baseRow.find(".addingRowBtn_Vertical").each(function (e) {
        $(this).on("click", function () {
            BaseRowController.AddBaseRow(
                self.id,
                $(this).attr('posType'),
            );
        })
    });


    return self;
};

$(document).ready(function () {
    BaseRowController.Init();
});


window.EditorController = BaseRowController;
