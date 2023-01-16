ProductController = {};


ProductController.list = {};

ProductController.OrderChange = function () {
    $('.basketLoading').show();
    $('.basketContainer').hide();

    $.get('/basket-raw', {}, function (data) {
        $('.basketContainer').html(data);
        $('.basketLoading').hide();
        $('.basketContainer').show();
    });


}


ProductController.GetApiLink = function (productId, increment) {
    var res = '/basket-api/add/' + productId + "/" + increment;
    console.log(increment);
    console.log(res);
    return res;
}

ProductController.BtnMinus = function (id) {
    ProductController.list[id].ClickIncrement(-1);
}

ProductController.BtnPlus = function (id) {
    ProductController.list[id].ClickIncrement(1);
}


ProductController.New = function (e) {

    var self = {};

    self.id = parseInt(e.attr('productId'));


    //e.find(".countController").hide();

    e.find("._btnPlus").on("mousedown", function () {
        ProductController.BtnPlus(self.id)
    });
    e.find("._btnMinus").on("mousedown", function () {
        ProductController.BtnMinus(self.id)
    });
    e.find(".btn_backet").on("mousedown", function () {
        ProductController.BtnPlus(self.id)
    });

    if (ProductController.list[self.id]) return;


    self.count = parseInt(e.attr('productOrder'));
    self.shopId = parseInt(e.attr('shopId'));

    self.Element = function () {
        return $('.product_' + self.id)
    }


    self.ClickIncrement = function (increment) {

        if (self.count < 1 && increment < 0) return;

        if (increment > 0) {
            self.Element().find("._monitorCount").text("Загрузка ...");
            self.Element().find("._btnMinus").hide();
            self.Element().find("._btnPlus").hide();
        }

        $.get(ProductController.GetApiLink(self.id, increment), {}, function (data) {
            console.log(data);



            //товары с другого магазина
            if (data.response == "current_shop") {
                $('#basketClearModal').modal('show');
                self.Render();
                return;
            }

            if (data.response == 'ok') {
                self.count = data.item_count;
                ProductController.OrderChange();
            }

            self.Render();

            if (data['warning']) {
                self.Warning(data['warning']);
            }

            if (data['error']) {
                self.Error(data['error']);
            }

        });
    };


    self.Warning = function (txt) {
        if (txt==null) {
            self.Element().find(".warning").hide();
        }
        self.Element().find(".warning").show();
        self.Element().find(".warning").text(txt);
    }

    self.Error = function (txt) {
        if (txt==null) {
            self.Element().find(".error").hide();
        }
        self.Element().find(".error").show();
        self.Element().find(".error").text(txt);
    }

    self.Render = function () {
        self.Element().find("._monitorCount").text(self.count);

        self.Element().find(".warning").hide();
        self.Element().find(".error").hide();

        self.Element().find("._btnMinus").show();
        self.Element().find("._btnPlus").show();
        if (self.count == 0) {
            self.Element().find(".countController").hide();
            self.Element().find(".btn_backet").show();
        } else {
            self.Element().find(".countController").show();
            self.Element().find(".btn_backet").hide();
        }
    }

    ProductController.list[self.id] = self;
    self.Render();

    return self;
}

ProductController.Init = function () {

    $('[productId]').each(function (index) {
        ProductController.New($(this));
    });

};


window.ProductController = ProductController;

$(document).ready(function () {
    ProductController.Init();
});
