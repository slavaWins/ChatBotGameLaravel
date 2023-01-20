<?php

namespace App\Http\Controllers\Bot\Admin\Bot;

use App\Characters\Shop\CarItemCharacterShop;
use App\Characters\Shop\GarageItemCharacterShop;
use App\Characters\Shop\MerchantShop;
use App\Http\Controllers\Controller;
use App\Models\Bot\Character;
use App\Models\Bot\ItemCharacterShop;
use App\Services\Bot\ParserBotService;
use Illuminate\Http\Request;

class ItemCharacterShopAdminController extends Controller
{


    public function categorys()
    {

        $categorys = ParserBotService::GetShopItmesClasses();

        return view('admin-extend.itemshop.cat', compact('categorys'));

    }

    public function editSave($catClassName, $id, Request $request)
    {

        $data = $request->toArray();

        /** @var  ItemCharacterShop $item */
        $catClassName = 'App\Characters\Shop\\' . $catClassName;

        $example = new $catClassName();
        $example->InitCastsStructure();

        $item = $catClassName::find($id);
        if (!$item) return redirect()->back();
        $item->InitCastsStructure();


        if ($data['doubleMake'] ?? false) {
            $example = $item->replicate();


            foreach ((array)$example->characterData as $K => $par) {
                if (!isset($data[$K])) continue;

                if ($example->characterData->$K > 2) {
                    $valevel = $example->characterData->$K * 0.3;
                    $valevel = round($valevel);
                    $example->characterData->$K += rand(-$valevel, $valevel);

                    $example->characterData->$K = max(0, $example->characterData->$K);

                }
            }

            $example->push();
            $example->save();

            return redirect()->back();
            /*
            $example = new $catClassName();
            $example->InitCastsStructure();
            $example->name  =$item->name;
            $example->price  =$item->price;
            $example->price  =$item->c;
        */
        }


        foreach ((array)$example->characterData as $K => $par) {
            if (!isset($data[$K])) continue;
            $item->characterData->$K = $data[$K];
        }

        $item->name = $data['name'] ?? $item->name;
        $item->price = $data['price'] ?? $item->price;
        $item->merchant_id = $data['merchant_id'] ?? 0;
        $item->save();

        return redirect()->back();
    }

    public function create($catClassName)
    {
        $catClassName = 'App\Characters\Shop\\' . $catClassName;
        $example = new $catClassName();
        $example->InitCastsStructure();


        $res = [];
        foreach ((array)$example->characterData as $K => $V) {
            $res[$K] = $V->value;
        }

        $example->characterData = $res;
        $example->className = $catClassName;
        $example->name = "Новый";
        $example->save();

        return redirect()->back();
    }

    public function showCategory($catClassName)
    {
        $catClassNameOriginal = $catClassName;

        $catClassName = 'App\Characters\Shop\\' . $catClassName;

        if (!class_exists($catClassName)) dd("no class " . $catClassName);

        $items = [];
        foreach (ItemCharacterShop::where("className", $catClassName)->get() as $V) {
            $items[] = $catClassName::find($V->id);
        }

        /** @var ItemCharacterShop $example */
        $example = new $catClassName();
        $example->InitCastsStructure();

        $merchantList = MerchantShop::GetMerchantsPluckList();

        $issetPriceVarible = isset($example->characterData->price);

        return view('admin-extend.itemshop.list', compact('items', 'catClassNameOriginal', 'example', 'merchantList','issetPriceVarible'));

    }

    public function update(Character $character, Request $request)
    {
        /** @var Character $character */
        $character = $character->className::LoadCharacterById($character->id);


        $stats = $character->GetStats();
        $charData = [];
        foreach ($request->toArray() as $K => $V) {
            if (!isset($stats->$K)) continue;
            $character->characterData->$K = $V;
        }
        //$character->characterData = $charData;
        $character->save();
        return redirect()->back();

    }


}
