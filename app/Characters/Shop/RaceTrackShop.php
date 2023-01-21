<?php

namespace App\Characters\Shop;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\RaceTrackStructure;
use App\Characters\RaceTrackCharacter;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property RaceTrackStructure characterData
 */
class RaceTrackShop extends ItemCharacterShop
{
    public $icon = "💒‍";
    public $baseName = "RaceTrack";
    const characterClass = null;
    public $titleShop = "Магазин RaceTrack";

    public $showInShopPreview = null;

    protected $casts = [
        'characterData' => RaceTrackStructure::class,
    ];
}
