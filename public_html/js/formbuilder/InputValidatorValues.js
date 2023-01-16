var InputValidatorValues = {};

InputValidatorValues.Digital = function (e, minLengh = 0, maxLengh = 999) {

    var self = InputValidatorValues.Base(e);

    self.Replace = function () {

        InputValidatorValues.Replaces.Digital(e);
    }

    self.Validate = function () {

        //if(e.val().length==0)return  false;
        if (e.val().length < minLengh) return "Поле должно содержать не менее " + minLengh + " цифр!";
        if (e.val().length > maxLengh) return "Поле должно содержать не более " + maxLengh + " цифр!";

        if (e.val().match(/^\d{0,999}$/)) {
            return true;
        }
        return "Не правильный формат числа!";

    }

    return self;
}

InputValidatorValues.String = function (e, minLengh = 0, maxLengh = 999) {

    var self = InputValidatorValues.Base(e);

    self.Replace = function () {


    }

    self.Validate = function () {

        //if(e.val().length==0)return  false;
        if (e.val().length < minLengh) return "Поле должно содержать не менее " + minLengh + " символов!";
        if (e.val().length > maxLengh) return "Поле должно содержать не более " + maxLengh + " символов!";


            return true;

    }

    return self;
}

InputValidatorValues.Money = function (e) {

    var self = InputValidatorValues.Base(e);

    self.Replace = function () {
        InputValidatorValues.Replaces.Float(e);
    }

    self.Validate = function () {
        if (e.val().match(/^\d+\.\d{0,2}$/)) {
            var ar = e.val().split('.');
            if (ar[0].substring(0, 1) == '0' && ar[0].length > 1) return "Сумма введена не корректно!";
            if (ar[1].length <= 0) return "Сумма введена не корректно!";
            return true;
        }

        if (e.val() == '0') return true;

        if (e.val().match(/^\d{0,42}$/)) {
            if (e.val().substring(0, 1) == '0') return "Сумма введена не корректно!";
            return true;
        }
        return "Сумма введена не корректно!";
    }

    return self;

}

InputValidatorValues.Replaces = {};

InputValidatorValues.Replaces.Float = function (e) {
    var val = e.val();
    val = val.replace(',', '.');
    val = val.replace(/[^0-9.]/g, '');
    var cursor = e.prop("selectionStart");
    if (cursor != val.length) cursor -= 1;

    if (val != e.val()) {
        e.val(val);
        e.setCursorPosition(cursor);
    }
}

InputValidatorValues.Replaces.Digital = function (e) {
    var val = e.val();
    val = val.replace(/[^0-9]/g, '');
    var cursor = e.prop("selectionStart");
    if (cursor != val.length) cursor -= 1;

    if (val != e.val()) {
        e.val(val);
        e.setCursorPosition(cursor);
    }
}

InputValidatorValues.Base = function (e) {
    var self = {};

    self.e = e;


    self.HideError = function () {
        e.removeClass('is-invalid');
        if (e.parent().find('.invalid-feedback').length > 0) {
            e.parent().find('.invalid-feedback').hide();
        }
    }

    self.ShowError = function (text) {
        e.addClass('is-invalid');


        if (text != null && typeof text == "string") {

            var _html = '<div class="invalid-feedback"></div>';

            if (e.parent().find('.invalid-feedback').length <= 0) {
                $(_html).insertAfter(e);
            }

            e.parent().find('.invalid-feedback').text(text );
            e.parent().find('.invalid-feedback').show();
        } else {
            if (e.parent().find('.invalid-feedback').length > 0) {
                e.parent().find('.invalid-feedback').hide();
            }
        }
    }


    self.Validate = function () {
        return true;
    }

    self.Update = function () {

        self.Replace();

        var _validate = self.Validate();
        if (self.Validate() !== true) {
            self.ShowError(_validate);
        } else {
            self.HideError();
        }

    }
    self.Replace = function () {

    }

    self.e.on("change", self.Update);
    self.e.on("keydown", self.Update);
    self.e.on("keyup", self.Update);


    return self;
}

InputValidatorValues.Init = function () {

    $(document).ready(function () {
        //InputValidatorValues.Money($("#id_fee"));
        // InputValidatorValues.Digital($("#id_customName"));

        $('[InputValidatorValues]').each(function (index) {

            var aMin = $(this).attr("InputValidatorValues-minlen") ?? 0;
            var aMax = $(this).attr("InputValidatorValues-maxlen") ?? null;


            switch ($(this).attr("InputValidatorValues")) {
                case "Money":
                    InputValidatorValues.Money($(this));
                    break;
                case "Digital":
                    InputValidatorValues.Digital($(this), aMin, aMax);
                    break;
                case "String":
                    InputValidatorValues.String($(this), aMin, aMax);
                    break;
            }

        });

    });

};


$.fn.setCursorPosition = function (position) {
    if (this.length == 0) return this;
    return $(this).setSelection(position, position);
}

$.fn.setSelection = function (selectionStart, selectionEnd) {
    if (this.length == 0) return this;
    var input = this[0];

    if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    } else if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    }

    return this;
}

$.fn.focusEnd = function () {
    this.setCursorPosition(this.val().length);
    return this;
}

window.InputValidatorValues = InputValidatorValues;

window.InputValidatorValues.Init();
