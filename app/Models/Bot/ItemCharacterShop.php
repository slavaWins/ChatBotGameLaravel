<?php

namespace App\Models\Bot;

use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property PlayerCharacterDataStructure characterData
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
