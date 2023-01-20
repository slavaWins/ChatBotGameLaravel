var LikeExcel = {};


LikeExcel.changeList = {};

LikeExcel.TdEditStart = function (e) {
    e.find("._val").hide();
    e.find("._edit").show();
    var _type = "text";
    if (e.attr("tdType") == "int") {
        _type = "number";
    }
    if (e.attr("tdType") == "select") {
        e.find("._edit").html("<select class='_input' ></select>");
        var options = e.attr("options");
        options = JSON.parse(options);

        var _cur = 0;
        for (const [key, value] of Object.entries(options)) {
            e.find("._edit select").append("<option value='" + key + "' >" + value + "</option>");
            if (e.find("._val").text().trim() == value) _cur = key;
        }
       // console.log(_cur);
        setTimeout(function () {
            e.find("._edit select").val(_cur).change();
        }, 50)

    } else {
        e.find("._edit").html("<input class='_input'  type='" + _type + "'>");
        e.find("._input").val(e.find("._val").text().trim());
    }

    e.find("._input").focus();

    e.find("._input").on('focusout', function () {
          LikeExcel.TdEditExit(e);
    })
}

LikeExcel.Save = function () {
    if ($('.le_btn_save').hasClass("disabled")) return;
    $('.le_btn_save').addClass("disabled");
    $('._tdchanged').removeClass("_tdchanged");
    console.log("save X");
    LikeExcel.changeList = {};
}

LikeExcel.TdEditExit = function (e) {
    if (!e) return;
    var _val = e.find("._edit ._input").val();

    if (e.attr("tdType") == "select") {
       var _valLocal = e.find("._edit ._input").val();
        _valLocal = e.find("._edit ._input").find('option[value="'+_valLocal+'"]').text().trim();
        e.find("._val").text(_valLocal);
    } else {
        _val = e.find("._edit ._input").val();
        e.find("._val").text(_val);
    }

    e.find("._val").show();
    e.find("._edit").hide();
    e.find("._edit").html("");
    e.addClass("_tdchanged");

    var id = parseInt(e.parent().attr("rowId"));
    var ind = e.attr("tdInd");
    if (!LikeExcel.changeList[id]) {
        LikeExcel.changeList[id] = {};
    }
    LikeExcel.changeList[id][ind] = _val;
    $('.le_btn_save').removeClass("disabled");
    console.log(LikeExcel.changeList);
}

LikeExcel.TdCursorExit = function (e) {
    if (!e) return;
    e.removeClass("_cursor");
}

LikeExcel.Eq = function (e1, e2) {
    if (!e1) return false;
    if (!e2) return false;
    return e1.attr("tdInd") == e2.attr("tdInd") && e1.attr("parentId") == e2.attr("parentId");
}
LikeExcel.TdCursorStart = function (e) {
    e.addClass("_cursor");

}

LikeExcel.new = function (e) {
    var self = {};
    self.e = e;
    self.cursorTd = null;
    self.editTd = null;


    self.StartEdit = function (e) {
        if (LikeExcel.Eq(self.editTd, e)) return;
        LikeExcel.TdEditExit(self.editTd);
        self.editTd = e;
        LikeExcel.TdEditStart(self.editTd);
    }
    e.find(".tr-body td").on('click', function () {
        if (self.cursorTd) {
            if (LikeExcel.Eq(self.cursorTd, $(this))) {
                if (LikeExcel.Eq(self.editTd, $(this))) return;
                self.StartEdit($(this));
                return;
            }
        }

        self.CursorTo($(this));
    });

    self.CursorTo = function (to) {
        if (self.cursorTd == to) return;
        LikeExcel.TdCursorExit(self.cursorTd);
        self.cursorTd = to;
        LikeExcel.TdCursorStart(self.cursorTd);
    }

    self.CursortMoveX = function (val) {

        if (self.editTd) LikeExcel.TdEditExit(self.editTd);
        var to = null;

        if (val == 1) to = self.cursorTd.next();
        if (val == -1) to = self.cursorTd.prev();

        if (!to) return;

        if (!to.attr("tdInd")) return;
        self.CursorTo(to);
    }

    self.CursortMoveY = function (val) {
        if (self.editTd) LikeExcel.TdEditExit(self.editTd);
        var rowTo = null;

        if (val == 1) rowTo = self.cursorTd.parent().next();
        if (val == -1) rowTo = self.cursorTd.parent().prev();

        if (!rowTo) return;

        if (!rowTo.attr("rowId")) return;

        var to = rowTo.find("td[tdInd='" + self.cursorTd.attr("tdInd") + "']")
        self.CursorTo(to);
    }

    $(document).bind("keydown", function (e) {
        if (e.ctrlKey && e.which == 83) {
            LikeExcel.Save();
            return false;
        }
        console.log(e.which);

        if (self.cursorTd) {
            if (e.which == 27) { //esc
                LikeExcel.TdCursorExit(self.cursorTd);
                LikeExcel.TdEditExit(self.editTd);
                self.cursorTd = null;
                return false;
            }
            if (e.which == 9 || e.which == 39) { //tab
                self.CursortMoveX(1);
                return false;
            }
            if (e.which == 13 || e.which == 40) { //enter
                if (!self.cursorTd) return true;
                self.CursortMoveY(1);
                return false;
            }
            if (e.which == 37) {
                self.CursortMoveX(-1);
                return false;
            }
            if (e.which == 38) {
                self.CursortMoveY(-1);
                return false;
            }
            if (self.cursorTd.attr("tdType") != "select") {
                self.StartEdit(self.cursorTd);
            }

        }
    });


    return self;
};


LikeExcel.Init = function () {
    $('.le_btn_save').on('click', function () {
        LikeExcel.Save();
    });


    $(".likeExcelTable").each(function (e) {
        LikeExcel.new($(this));
    });
}

$(document).ready(function () {
    LikeExcel.Init();
});

window.LikeExcel = LikeExcel;
