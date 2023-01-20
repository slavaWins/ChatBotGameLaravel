<?php

namespace App\Http\Controllers\LikeExcel;

use App\Http\Controllers\Controller;
use App\Models\Bot\Character;
use App\Models\Bot\History;
use app\Models\Trash\Order;
use app\Models\Trash\Shop;
use App\Models\User;

class LikeExcelController extends Controller
{

    public function index()
    {


        $xz = '';
/*
        $colums = [];
        $colums['name'] = [
            'name' => 'Имя',
            'type' => 'string',
        ];
        $colums['year'] = [
            'name' => 'Возраст',
            'type' => 'int',
        ];
        $colums['myid'] = [
            'name' => 'Код',
            'type' => 'int',
        ];
        $colums['partType'] = [
            'name' => 'Тип детали',
            'type' => 'select',
            'options' => [
                1 => "gavno",
                2 => "gavno2",
                3 => "gavno3",
            ],

        ];
        $colums['cbc'] = [
            'name' => 'Код',
            'type' => 'int',
            'partType' => 1,
        ];

        $data = [];
        $data[] = [
            'name' => 'Megan',
            'year' => 22,
            'myid' => 135,
            'partType' => 2,
        ];
        $data[] = [
            'name' => 'Megan',
            'year' => 22,
            'myid' => 135,
            'myid' => 3,
        ];
*/
        $colums=[];
        $data=[];
        $list = Character::all();

        /** @var Character $character */
        $character = $list->first();
        foreach ($character->characterData as $K => $V) {
            $colums[$K] = [
                'name' => $K,
                'type' => 'text',
            ];
        }

        foreach ($list as $character) {

            $data[$character->id] = (array)$character->characterData;
        }

        return view('like-excel.index', compact('xz', 'colums', 'data'));

    }


}
