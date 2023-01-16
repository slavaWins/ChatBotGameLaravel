var Messagebox = {};

Messagebox.currentOption = {
    text: "bottom",//добавить снизу или сверху
};

Messagebox.textarea = null;

Messagebox.Sendmessage = function (cmdBtn = "") {

    Messagebox.currentOption.text = Messagebox.textarea.val();
    if (cmdBtn) {
        Messagebox.currentOption.text = cmdBtn;
    }

    Messagebox.textarea.val("");


    EasyApi.Post('/api/messagebox/send', Messagebox.currentOption, function (response, error) {
        if (error) {
            window.open('/api/messagebox/send?onlytext=1&text='+ Messagebox.currentOption.text, '_blank').focus();
            return;
        }
        console.log("sended");

        $('.mess_row_btns').html("");
        console.log(response.response);
        $('.mess_scroll').append(response.response.html)
        $('.mess_row_btns').html(response.response.buttons_html)
        Messagebox.Bottom();
    });


}


Messagebox.Bottom = function () {
    $('.mess_scroll').scrollTop($('.mess_scroll')[0].scrollHeight);
}

Messagebox.Init = function () {
    Messagebox.textarea = $('.textarea_mess');

    Messagebox.Bottom();
    Messagebox.textarea.keyup(function (event) {

        if (event.key == "Escape") {
            $(this).blur()
            return;
        }


        if (Messagebox.textarea.val().trim() == "") return;
        if (event.key == "Enter") {
            Messagebox.Sendmessage();
        }


    });


}

$(document).ready(function () {
    Messagebox.Init();
});


window.Messagebox = Messagebox;
