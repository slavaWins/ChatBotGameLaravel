var EditorTextera = {};


EditorTextera.Init = function () {
    $(".textarea_simple_text").each(function (e) {
        EditorTextera.new($(this));
    });
}

EditorTextera.new = function (e) {
    var self = {};


    self.e = e;
    self.isTrimMode = e.attr("trim") != undefined;

    e.keydown(function (event) {

        if (self.isTrimMode) {
            if (event.key == "Enter") {
                return false;
            }
        }

        var addingRowBtn = $(this).parent().parent().find(".addingRowBtn");
        addingRowBtn.offset().top = 200;
    });


    e.keyup(function (event) {

        if (event.key == "Escape") {
            $(this).blur()
            return;
        }

        if (self.isTrimMode) {
            e.val(e.val().trim());
            if (event.key == "Enter") {
                return false;
            }
        }

        $(e).height(0);
        while ($(e).outerHeight() < this.scrollHeight + parseFloat($(e).css("borderTopWidth")) + parseFloat($(e).css("borderBottomWidth"))) {
            $(e).height($(e).height() + 1);
        }
    });

    return self;
};

$(document).ready(function () {
    EditorTextera.Init();
});


window.EditorTextera = EditorTextera;
