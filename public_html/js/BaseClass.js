var IPage = {};

IPage.new = function () {
    var self = {};

    var title = "def";
    self.SetTitle = function (val) {
        title= val;
        return self;
    };


    self.Render = function () {
        return self;
    };

    self.Init = function () {
        console.log("BaseClass init ready");
        return self;
    };

    document.addEventListener("DOMContentLoaded", function(event) {
        $(document).ready(function(){
            self.Init();
        });
    });

    return self;
};

