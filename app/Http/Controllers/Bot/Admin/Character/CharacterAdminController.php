<?php

namespace App\Http\Controllers\Bot\Admin\Character;

use App\Http\Controllers\Controller;
use App\Models\Bot\Character;
use app\Models\Trash\Order;
use app\Models\Trash\Shop;
use Illuminate\Http\Request;

class CharacterAdminController extends Controller
{
    public function index()
    {

        $characters = Character::all();

        return view('admin-extend.character.list', compact('characters'));

    }

    public function show(Character $character)
    {

        $character = $character->className::LoadCharacterById($character->id);

        return view('admin-extend.character.show', compact('character'));

    }

    public function update(Character $character, Request $request)
    {
        /** @var Character $character */
        $character = $character->className::LoadCharacterById($character->id);


        $stats = $character->GetStats();
        $charData = [];
        foreach ($request->toArray() as $K => $V) {
            if (!isset($stats->$K)) continue;
            $charData[$K] = $V;
        }
        $character->characterData = $charData;
        $character->save();
        return redirect()->back();

    }


}
