<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\WorkbenchStruct;
use App\Characters\WorkbenchCharacter;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property WorkbenchStruct characterData
 */
class WorkbenchShop extends ItemCharacterShop
{
    public $icon = "🛠️";
    public $baseName = "Верстак";
    const characterClass = WorkbenchCharacter::class;
    public $filter_by = "workTo";
    public $titleShop = "Магазин верстаков";

    public $showInShopPreview = [
        "skill_size",
        "skill_teh",
    ];

    protected $casts = [
        'characterData' => WorkbenchStruct::class,
      //  'characterDataRand' => WorkbenchStruct::class,
    ];
}
