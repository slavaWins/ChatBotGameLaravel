<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property GarageCharacterDataStructure characterData
 */
class GarageItemCharacterShop extends ItemCharacterShop
{
    public $icon = "💒‍";
    public $baseName = "Гараж";


    public $showInShopPreview = [
        "skill_size",
        "skill_teh",
    ];

    protected $casts = [
        'characterData' => GarageCharacterDataStructure::class,
    ];
}
