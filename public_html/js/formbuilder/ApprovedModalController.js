ApprovedModalController = {};


ApprovedModalController.New = function (e) {

    var self = {};

    self.e = e;
    self.url = e.attr('href');
    e.attr('href', "#")
    self.title = e.attr('approvedModal');

    self.Click = function (e) {
        $("#modalApproved").modal('show');
        $("#modalApprovedTitle").text(self.title);
        $(".modalApprovedHrefElement").attr("href", self.url);
    };

    self.e.on("mousedown", self.Click);

    return self;
}

ApprovedModalController.Init = function () {

    $('[approvedModal]').each(function( index ) {
        ApprovedModalController.New($( this ));
    });

};


window.ApprovedModalController = ApprovedModalController;
window.ApprovedModalController.Init();
