<?php

namespace App\Models\Bot;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CarCharacterDataStructure characterDataRand
 * @property CarCharacterDataStructure characterData
 * @property int $id
 * @property int price
 * @property int merchant_id
 * @property int buy_count
 * @property string className
 * @property string name
 */
class ItemCharacterShop extends Model
{
    use HasFactory;

    public $icon = "X";
    public $baseName = "Предмет";
    public $titleShop = "Магазин предметов";

    public $filter_by = null; //позволяет выбрать как фильр в магазине по статкам. Нужно написать название статки marka например

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
      //  'characterDataRand' => PlayerCharacterDataStructure::class,
    ];

    protected $table = 'item_character_shops';

    public static function RandomizeDatabase(){
        $className = get_called_class(); //для статик класа так получается
       // $character = Character::where('user_Id', $user_id)->where('className', $className)->first();
    }

    public function GetStatsStruct(){
        return new $this->casts['characterData']($this->characterData);
    }
    public function InitCastsStructure()
    {
        if (!$this->characterData) {
            $this->characterData=  new $this->casts['characterData']();
         //   $this->characterDataRand=  new $this->casts['characterData']();
        }

    }

    /**
     * @return ItemCharacterShop
     */
    public static function FindById($id){
        $className = get_called_class(); //для статик класа так получается

        return $className::find($id) ?? null;
    }

    /**
     * @return ItemCharacterShop[]
     */
    public static function GetItmes(){
        $className = get_called_class(); //для статик класа так получается

        $items = [];
        foreach (ItemCharacterShop::where("className", $className)->get() as $V) {
            $items[] = $className::find($V->id);
        }

        return collect($items);
    }
}
