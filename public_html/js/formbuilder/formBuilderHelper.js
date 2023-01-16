window.CheckboxAttachHideDiv = function (e, div){
    var self ={};
    self.Render = function (){
        if(e.is(':checked')) {
            div.show();
        }else{
            div.hide();
        }
    }
    e.on("change", self.Render);

    self.Render();
    return self;
}
