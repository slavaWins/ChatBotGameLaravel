<?php

namespace App\Characters\Shop;


use App\Characters\Struct\MerchantStructure;
use App\Models\Bot\ItemCharacterShop;


/**
 * @property MerchantStructure characterData
 */
class MerchantShop extends ItemCharacterShop
{
    public $icon = "💒‍";
    public $baseName = "Торговец";

    public $titleShop = "Магазин Merchant";

    public $showInShopPreview = [
        "hp",
        "size",
    ];

    protected $casts = [
        'characterData' => MerchantStructure::class,
    ];

    public static function GetMerchantsPluckList()
    {
        $list = [];
        $list[0] = "Без торговца";
        foreach (MerchantShop::GetItmes() as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }
}
