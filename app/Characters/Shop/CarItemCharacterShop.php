<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCalculateDataStructure;
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

    protected $casts = [
        'characterData' => CarCharacterDataStructure::class,
    ];
}
