<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;
use App\Services\Bot\ParserBotService;

class MerchantStructure extends BaseCharacterDataCast
{

    public $price = 1;
    public $targetClass = "all";

    public function __construct($characterData = [])
    {
        $list = ParserBotService::GetCharacterClasses();
        $list[] = "all";


        $this->targetClass = StatStructure::Make("Торгует типом товаров")
            ->SetDefault("all")->SetOptions($list)->Hidden()
            ->SetIcon("⚙")->SetMax(100)->SetShowInShort(true);


        $this->price = StatStructure::Make("Процент накрутки")->SetDefault(100)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
