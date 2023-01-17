<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\WorkbenchStruct;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property WorkbenchStruct characterData
 */
class WorkbenchShop extends ItemCharacterShop
{
    public $icon = "🛠️";
    public $baseName = "Верстак";


    public $showInShopPreview = [
        "skill_size",
        "skill_teh",
    ];

    protected $casts = [
        'characterData' => WorkbenchStruct::class,
    ];
}
