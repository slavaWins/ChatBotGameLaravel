<?php

namespace App\Characters\Shop;

use App\Characters\EnginePartCharacter;
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
    public $icon = "💠";
    public $baseName = "EnginePart";
    const characterClass = EnginePartCharacter::class;
    public $titleShop = "Магазин запчастей";

    public $filter_by = "partType";

    public $showInShopPreview = null;

    protected $casts = [
        'characterData' => EnginePartStructure::class,
    ];
}
