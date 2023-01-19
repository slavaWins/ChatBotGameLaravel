<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\StoCharacterDataStructure;
use App\Characters\Struct\WorkbenchStruct;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property StoCharacterDataStructure characterData
 */
class StoShop extends ItemCharacterShop
{
    public $icon = "🛠️";
    public $baseName = "СТО";

    //public $filter_by = "workTo";
    public $titleShop = "СТО";


    public $showInShopPreview = [
        "skill_size",
        "skill_teh",
    ];

    protected $casts = [
        'characterData' => StoCharacterDataStructure::class,
    ];
}
