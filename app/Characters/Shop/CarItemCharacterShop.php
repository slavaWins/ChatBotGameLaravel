<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property CarCharacterDataStructure characterData
 */
class CarItemCharacterShop extends ItemCharacterShop
{
    public $icon = "🚘";
    public $baseName = "Автомобиль";
    public $titleShop = "Автосалон";


    public $showInShopPreview = [
        "hp",
        "power",
    ];

    protected $casts = [
        'characterData' => CarCharacterDataStructure::class,
      //  'characterDataRand' => CarCharacterDataStructure::class,
    ];
}
