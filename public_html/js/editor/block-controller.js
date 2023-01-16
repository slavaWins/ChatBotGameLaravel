var BlockController = {};

BlockController.currentOption = {
    project_id: 0,
    blockId: 0,
    posAfter: 0,
    posType: "bottom",//добавить снизу или сверху
    pos: 0, //позициая сортировки
};

BlockController.requestCreateBlock = {
    project_id: 0,
    row_id: 0,
    pos: 0,
    ind: 0,
};


BlockController.CreateBlockNewRequest = function (e) {

    var blockId = parseInt(e.attr("blockId"));


    BlockController.requestCreateBlock.pos = 0;

    if (blockId > 0) {
        var blockFrom = BlockController.blocks[blockId];
        BlockController.requestCreateBlock.pos = blockFrom.pos + 1;
    }

    BlockController.requestCreateBlock.project_id = BlockController.currentOption.project_id;
    BlockController.requestCreateBlock.row_id = parseInt(e.attr("baserow_id"));
    BlockController.requestCreateBlock.ind = "h1";

    WindowEditorController.windowBlockCreate.Open(BlockController.requestCreateBlock);

}


BlockController.DragResort = function (baseRowId) {
    console.log("DragResort");
    var baseRowClass = BaseRowController.baseRows[baseRowId];
    var mapSort={};
    var i =0;
    baseRowClass.e.find(".blockDiv").each(function (){
        i+=10;
        mapSort[$(this).attr('blockId')] = i;
    });

    var data = {};
    data.project_id = BaseRowController.currentOption.project_id;
    data.mapSortData = mapSort;

    EasyApi.Post('/api/editor/map_sort_blocks', data, function (response, error) {
        if (error) return;
        console.log("SAVE sort");
    });
}


BlockController.DragMoveBlock = function (blockId, toBaseRowId) {
    var baseRowClass = BaseRowController.baseRows[toBaseRowId];
    console.log("DragMoveBlock");

}

BlockController.Init = function () {
    BlockController.currentOption.project_id = $('PROJECT_ID').text();


    $('.content-border').sortable({
        //handle:         '.blockDiv',
        update: function (event, ui) {
            var row_id = parseInt($(this).attr("baseRowId"));
            var block = $(ui.item);
            var blockId = parseInt( block.attr("blockId"));

            if (BlockController.blocks[blockId].baserow_id == row_id) {
                BlockController.DragResort(row_id);
            } else {
                BlockController.DragMoveBlock(blockId, row_id);
            }
        },
        connectWith: ".content-border"
    }).disableSelection();


    $(".blockDiv").each(function (e) {
        var block = $(this);
        BlockController.New(block);
    });

    $('.addingRowBtn_Right').on('click', function () {
        BlockController.CreateBlockNewRequest($(this));
    });

    $('.addingRowBtn_Left').on('click', function () {
        console.log("move");
    });

    $('.btnEditorSaveChange').on('click', function () {
        $('.btnEditorSaveChange').hide();


        var data = {};
        data.project_id = BaseRowController.currentOption.project_id;
        data.textaraeForSaveData = BlockController.textaraeForSaveData;


        EasyApi.Post('/api/editor/update_textareas', data, function (response, error) {
            if (error) return;
            console.log("SAVE");
        });
        BlockController.textaraeForSaveData = {};
    })

}

BlockController.textaraeForSaveData = {};

BlockController.blocks = {};


BlockController.New = function (block) {
    var self = {};


    self.e = block;
    self.pos = parseInt(block.attr('pos'));
    self.id = parseInt(block.attr('blockId'));
    self.baserow_id = parseInt(block.attr('baseRowId'));
    self.textera = block.find("textarea");
    self.baserowDiv = $('.baseRow_' + self.baserow_id);
    self.addingRowBtn_Right = self.baserowDiv.find('.addingRowBtn_Right');
    self.addingRowBtn_Left = self.baserowDiv.find('.addingRowBtn_Left');


    if (BlockController.blocks[self.id]) return;
    BlockController.blocks[self.id] = self;

    self.textera.on("input", function () {
        BlockController.textaraeForSaveData[self.id] = self.textera.val();
        $(".btnEditorSaveChange").show();
    });

    self.e.on("mouseenter", function () {
        var h = self.e.height()
        self.addingRowBtn_Right.offset({top: self.e.offset().top + h / 2 - 20});
        self.addingRowBtn_Right.attr("blockId", self.id);

        self.addingRowBtn_Left.offset({top: self.e.offset().top + h / 2 - 20});
        self.addingRowBtn_Left.attr("blockId", self.id);
    });

    return self;
};

$(document).ready(function () {
    BlockController.Init();
});


window.EditorController = BlockController;
