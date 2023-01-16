<?php

namespace App\Http\Controllers\Admin\Bot;

use App\Characters\Shop\CarItemCharacterShop;
use App\Http\Controllers\Controller;
use App\Models\Bot\Character;
use App\Models\Bot\ItemCharacterShop;
use Illuminate\Http\Request;

class ItemCharacterShopAdminController extends Controller
{

    public function categorys()
    {


        $categorys = [
            new  CarItemCharacterShop()
        ];

        return view('admin.itemshop.cat', compact('categorys'));

    }

    public function editSave($catClassName, $id, Request $request)
    {
        $data = $request->toArray();
        /** @var  ItemCharacterShop $example */
        $catClassName = 'App\Characters\Shop\\' . $catClassName;
        $example = $catClassName::find($id);
        if (!$example) return redirect()->back();
        $example->InitCastsStructure();

        foreach ((array)$example->characterData as $K => $par) {
            if (!isset($data[$K])) continue;
            $example->characterData->$K = $data[$K];
        }

        $example->name = $data['name'] ?? $example->name;
        $example->price = $data['price'] ?? $example->price;
        $example->save();

        return redirect()->back();
    }

    public function create($catClassName)
    {
        $catClassName = 'App\Characters\Shop\\' . $catClassName;
        $example = new $catClassName();
        $example->InitCastsStructure();
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

        return view('admin.itemshop.list', compact('items', 'catClassNameOriginal', 'example'));

    }

    public function update(Character $character, Request $request)
    {
        /** @var Character $character */
        $character = $character->className::LoadCharacterById($character->id);
        $character->ReCalc();

        $stats = $character->GetStats();
        $charData = [];
        foreach ($request->toArray() as $K => $V) {
            if (!isset($stats[$K])) continue;
            $charData[$K] = $V;
        }
        $character->characterData = $charData;
        $character->save();
        return redirect()->back();

    }


}
