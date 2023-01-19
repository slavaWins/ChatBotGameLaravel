<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\TemplateStructure;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property TemplateStructure characterData
 */
class TemplateShop extends ItemCharacterShop
{
    public $icon = "💒‍";
    public $baseName = "Template";

    public $titleShop = "Магазин Template";

    public $showInShopPreview = [
        "hp",
        "size",
    ];

    protected $casts = [
        'characterData' => TemplateStructure::class,
    ];
}
