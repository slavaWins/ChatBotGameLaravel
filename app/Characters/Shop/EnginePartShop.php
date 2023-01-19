<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\EnginePartStructure;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property EnginePartStructure characterData
 */
class EnginePartShop extends ItemCharacterShop
{
    public $icon = "💒‍";
    public $baseName = "EnginePart";

    public $titleShop = "Магазин EnginePart";

    public $showInShopPreview = [
        "hp",
        "size",
    ];

    protected $casts = [
        'characterData' => EnginePartStructure::class,
    ];
}
