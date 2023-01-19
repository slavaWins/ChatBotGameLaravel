<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property GarageCharacterDataStructure characterData
 */
class TemplateShop extends ItemCharacterShop
{
    public $icon = "💒‍";
    public $baseName = "Гараж";

    public $titleShop = "Аренда гаража";

    public $showInShopPreview = [
        "size",
    ];

    protected $casts = [
        'characterData' => GarageCharacterDataStructure::class,
    ];
}
