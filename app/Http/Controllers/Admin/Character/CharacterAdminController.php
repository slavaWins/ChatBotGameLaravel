<?php

namespace App\Http\Controllers\Admin\Character;

use App\Http\Controllers\Controller;
use App\Models\Bot\Character;
use app\Models\Trash\Order;
use app\Models\Trash\Shop;
use App\Models\User;
use Facade\FlareClient\Stacktrace\Stacktrace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CharacterAdminController extends Controller
{
    public function index()
    {

        $characters = Character::all();

        return view('admin.character.list', compact('characters'));

    }

    public function show(Character $character)
    {

        $character = $character->className::LoadCharacterById($character->id);
        $character->ReCalc();
        return view('admin.character.show', compact('character'));

    }

    public function update(Character $character, Request $request)
    {
        /** @var Character $character */
        $character = $character->className::LoadCharacterById($character->id);
        $character->ReCalc();

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
