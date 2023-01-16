<?php

namespace App\Models\Bot;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CarCharacterDataStructure characterData
 * @property int $id
 * @property int price
 * @property int buy_count
 * @property string className
 * @property string name
 */
class ItemCharacterShop extends Model
{
    use HasFactory;

    public $icon = "X";
    public $baseName = "Предмет";

    public $filter_by = "marka"; //позволяет выбрать как фильр в магазине по статкам

    /**
     * Какие статки показывать в превью магазина?
     * @var string[]
     */
    public $showInShopPreview = [
        "hp",
        "power",
    ];


    protected $casts = [
        'characterData' => PlayerCharacterDataStructure::class,
    ];

    protected $table = 'item_character_shops';

    public function InitCastsStructure()
    {
        if (!$this->characterData) {
            $this->characterData = new $this->casts['characterData']();
        }
    }
}
