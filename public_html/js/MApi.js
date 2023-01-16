
var MApi = {};

MApi.fakeDelay = 250;


MApi.ToForm = function (formInd, data) {
    //console.log(data);
    //console.log(typeof(data));

    var formDiv = $(formInd);

    Object.keys(data).forEach(function (key) {
        var val = data[key];
        if (formDiv.find("#" + key).length) {

            var theInput = formDiv.find("#" + key);

            theInput.val(val);

            if(theInput.attr("type")=="date"){

                var date = new Date(val);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                if (month < 10) month = "0" + month;
                if (day < 10) day = "0" + day;
                var today = year + "-" + month + "-" + day ;
                val  = today;
                theInput.val(val);
            }

            //console.log(theInput.attr("type"));
            // console.log(key);
            // console.log(val);

        }
    });
};


MApi.ApiWeb = function (method, AR, FUN) {
    var url = '/webapi/' + method;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
        }
    });

    setTimeout(function () {
        $.post(url, AR, function (d) {
            // d = JSON.parse(d);
            if (FUN != null) FUN(d);
        });

    }, MApi.fakeDelay);
};
