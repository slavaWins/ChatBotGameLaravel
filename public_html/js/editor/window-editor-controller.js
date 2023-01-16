var WindowEditorController = {};

WindowEditorController.currentOption = {
    project_id: 0,
    baseRowId: 0,
    posAfter: 0,
    posType: "bottom",//добавить снизу или сверху
    pos: 0, //позициая сортировки
};


WindowEditorController.ToPos = function (selector, btnElement) {
    var e = $(selector);
    e.show();
    var offset = btnElement.offset();
    var top = offset.top;
    console.log(top);

    e.offset({top: top, left: offset.left - 400});
    if(top>120) {
        e.css("top", "120px");
    }
    WindowEditorController.Show(selector);
}

WindowEditorController.Hide = function () {
    $('.windowEditorOverlay').hide();
    $('.windowEditor').hide();
}

WindowEditorController.Show = function (selector) {
    var e = $(selector);
    e.show();
    $('.windowEditorOverlay').show();
}


WindowEditorController.windowEditorSection = {};

WindowEditorController.windowEditorSectionInit = function () {
    var windowEditorSectionElement = $(".windowBaseRow");
    var self = WindowEditorController.New(windowEditorSectionElement);
    self.baseRowId = 0;
    self.baseRowClass = null;
    self.parmetersPrev = null;


    self.Save = function () {
        var data = self.baseRowClass.parameters;
        data.baseRowId = self.baseRowId;
        data.project_id = BaseRowController.currentOption.project_id;

        EasyApi.Post('/api/editor/update_parameters', data, function (response, error) {
            if (error) return;
        });
    }

    self.Render = function () {
        for (const [key, value] of Object.entries(self.baseRowClass.parameters)) {
            self.baseRowClass.parameters[key] = self.e.find('#inp_' + key).val();
        }


        self.baseRowClass.e.css('padding-top', (self.baseRowClass.parameters.paddingVertical)+"px");
        self.baseRowClass.e.css('padding-bottom', (self.baseRowClass.parameters.paddingVertical)+"px");

        self.baseRowClass.e.find(".backoverlay").css('opacity', (self.baseRowClass.parameters.overlayOpacity / 100));
        self.baseRowClass.e.find(".backoverlay").css('background', self.baseRowClass.parameters.overlayColor);
        self.baseRowClass.e.css('background', "url('" + (self.baseRowClass.parameters.backgroundUrl) + "') center");
        self.baseRowClass.e.css('color', self.baseRowClass.parameters.textColor);
    }


    self.ParametersToInputs = function () {
        for (const [key, value] of Object.entries(self.baseRowClass.parameters)) {
            self.e.find('#inp_' + key).val(value);
        }
    }
    self.LoadByRowId = function (baseRowId) {

        self.baseRowId = baseRowId;
        self.baseRowClass = BaseRowController.baseRows[baseRowId]

        self.parmetersPrev = structuredClone(self.baseRowClass.parameters);

        self.ParametersToInputs();
    };

    self.e.find("input").on('input', self.Render);


    self.e.find(".btnClose").on('click', function () {
        self.baseRowClass.parameters = structuredClone(self.parmetersPrev);
        self.ParametersToInputs();
        self.Render();
    });

    self.e.find(".btnSave").on('click', function () {
        self.Render();
        self.Save();
        WindowEditorController.Hide();
    });

    WindowEditorController.windowEditorSection = self;
}


WindowEditorController.windowEditorBlockCreateInit = function () {
    var windowEditorSectionElement = $(".windowBlockCreate");
    var self = WindowEditorController.New(windowEditorSectionElement);

    self.requestCreateBlock = {};


    self.Select = function (ind) {
        self.requestCreateBlock.ind = ind;
        self.Send();
    }

    self.Send = function () {
        console.log(self.requestCreateBlock.ind );
        EasyApi.Post('/api/editor/block_add', self.requestCreateBlock, function (response, error) {
            if (error) {
                return;
            }
            location.reload();
        });

        WindowEditorController.Hide();
    }

    self.Open = function (requestCreateBlock) {
        self.requestCreateBlock = requestCreateBlock;
        self.Show();
    };


    WindowEditorController.windowBlockCreate = self;
}

WindowEditorController.Init = function () {
    WindowEditorController.currentOption.project_id = $('PROJECT_ID').text();
    /*
        $(".windowEditor").each(function (e) {
            var windowEditor = $(this);
            WindowEditorController.New(windowEditor);
        });
    */
    $('.windowEditorOverlay').on('click', function () {
        WindowEditorController.Hide();
    });

    WindowEditorController.windowEditorSectionInit();
    WindowEditorController.windowEditorBlockCreateInit();

}

WindowEditorController.list = {};

WindowEditorController.New = function (e) {
    var self = {};


    self.e = e;
    self.e.hide();


    e.find(".btnClose").on("click", function () {
        WindowEditorController.Hide();
    });

    self.Show = function () {
        e.show();
        $('.windowEditorOverlay').show();
    }

    return self;
};

$(document).ready(function () {
    WindowEditorController.Init();
});


window.EditorController = WindowEditorController;
