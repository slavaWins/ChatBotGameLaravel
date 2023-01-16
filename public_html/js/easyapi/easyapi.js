//v 1.2
var EasyApi = {};

EasyApi.Post = function (url, date, callback, callbackError) {
    date._token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
            'method': 'post',
            'data': date,
            'url': url,
        }
    )
    .fail(function (info) {
        console.log("FAIL");
        console.log(info);
        callback(null, "error status");
    })
    .done(function (response) {
        var error = null;
        if (response['error']) {
            console.log(url + " ERROR: " + response.message);
            error = response.message;
        }
        callback(response, error);
    });
}

EasyApi.new = function () {
    var self = {};
    return self;
};


window.EasyApi = EasyApi;
