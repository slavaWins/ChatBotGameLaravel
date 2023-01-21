<?php

namespace App\Http\Controllers\Bot\Virtual;


use App\BotTutorials\BotTutorialBase;
use App\BotTutorials\StartTutorial;
use App\Characters\PlayerCharacter;
use App\Http\Controllers\Bot\BotLogicController;
use App\Http\Controllers\Controller;
use App\Library\PhpWriter\Writer;
use App\Models\Bot\VirtualRoom;
use App\Models\ResponseApi;
use Illuminate\Http\Request;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Library\Vk\VkAction;
use App\Models\Bot\History;
use App\Models\Bot\Scene;
use App\Models\Bot\VirtualStep;
use App\Models\User;
use App\Scene\Core\BaseRoom;
use App\Scene\HomeRoom;
use App\Scene\RegistrationRoom;
use App\Scene\TestVirtualRoom;
use App\Services\Bot\ParserBotService;
use Illuminate\Support\Facades\Auth;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;
use Throwable;


/**
 * @property BaseRoom $sceneRoom
 */
class RoomVirtualController extends Controller
{


    public function store(VirtualStep $vs, Request $request)
    {

        $data = $request->toArray();

        unset($data['_token']);
        unset($data['id']);

        $ar = $vs->toArray();
        foreach ($data as $K => $V) {
            //    if(!isset($ar[$K]))continue;
            $vs->$K = $V;
        }

        if ($vs->selector_character == "not") $vs->selector_character = null;
        if ($vs->btn_scene_class == "not") $vs->btn_scene_class = null;
        if ($vs->btn_shop_class == "not") $vs->btn_shop_class = null;

        if (!$vs->save()) {
            return ResponseApi::Error("error save");
        }

        self::GenereateCode($vs->className);

        return ResponseApi::Successful();
        //return redirect(route('bot.virtual.room', $vs->className).'#step_id'.$vs->id);
    }


    public function updateRoom(VirtualRoom $vs, Request $request)
    {

        $data = $request->toArray();

        unset($data['_token']);
        unset($data['id']);

        foreach ($data as $K => $V) {
            $vs->$K = $V;
        }

        if ($vs->item_varible_class1 == "not") $vs->item_varible_class1 = null;
        if ($vs->item_varible_class2 == "not") $vs->item_varible_class2 = null;
        $vs->save();

        self::GenereateCode($vs->className);
        return redirect()->back();
    }

    public static function GetVirtualClassByName($className)
    {
        if (!substr_count($className, "Virtual")) return null;

        foreach (ParserBotService::GetRoomClasses() as $V) {
            if (basename($V) == $className) return $V;
        }
        return null;
    }


    public static function GenereateCode($className)
    {

        $room = VirtualRoom::where('className', $className)->first();
        $steps = VirtualStep::where('className', $className)->get();

        //  $steps = VirtualStep::all();
        $text = view("bot.virtual.code.room", compact(['steps', "className", 'room']));

        //  $text = Writer::CodeCommentator($text);
        $text = Writer::CodeFormater($text);

        $text = '<' . '?php' . "\n" . $text;


        $p = app_path() . '/Scene/Virtual/' . $className . '.php';

        file_put_contents($p, $text . ' ');
        return true;
    }

    function createStep($className)
    {

        $steps = VirtualStep::where("className", $className)->count();

        $vs = new VirtualStep();
        $vs->className = $className;
        $vs->start_message = "Что вы хотите сделать?";
        $vs->step = $steps;
        $vs->save();

        return redirect()->back();
    }

    function createRoom(Request $request)
    {
        $className = $request->toArray()['className'];

        if (!substr_count($className, "VirtualRoom")) $className = $className . 'VirtualRoom';
        if (self::GetVirtualClassByName($className)) return redirect()->back()->withErrors("Занатый класса");

        $vs = new VirtualRoom();
        $vs->className = $className;

        $vs->save();

        return redirect()->back();
    }

    function index($className)
    {


        $room = VirtualRoom::where("className", $className)->first();

        if (!$room) return redirect()->back()->withErrors("Не найден виртуальный класс");
        $steps = VirtualStep::where("className", $className)->get();

        $user = Auth::user();
        return view("bot.virtual.room", compact(['steps', "user", "className", "room"]));
    }

    function play($className)
    {

        Scene::where("debug_play", true)->delete();

        $user = Auth::user();

        $botRequestStructure = new BotRequestStructure();
        $botRequestStructure->user = $user;
        $botRequestStructure->message = "DEBUG_START";

        $cn = self::GetVirtualClassByName($className);
        /** @var BaseRoom $scene */
        $scene = new $cn($botRequestStructure);
        $scene->scene->debug_play = true;
        $scene->scene->save();

        $bl = new BotLogicController();
        $bl->Message($user, $botRequestStructure);

        return redirect()->route("messagebox.index");
    }

    const fetFilterSelectorCharacter = [
        'player' => "Принадлежит игроку",
        'all' => "Вообще все",
        'player_parentRoomCharacter1' => "Игрока. И child переменной 1",
        'player_parentRoomCharacter2' => "Игрока. И child переменной 2",
    ];

    public static function FilterSelectorCharacter(VirtualRoom $room)
    {
        return [
            'player' => "Принадлежит игроку",
            'all' => "Вообще все",
            'player_parentRoomCharacter1' => "Принадлежит " . $room->item_varible_name1 ?? " var1",
            'player_parentRoomCharacter2' => "Принадлежит " . $room->item_varible_name2 ?? " var2",
        ];
    }

    public static function RoomVaribles(VirtualRoom $room)
    {


        return [
            'not' => "Никуда",
            'var1' => $room->item_varible_name1 ?? " var1",
            'var2' => $room->item_varible_name2 ?? " var2",
        ];
    }


    public function character($className)
    {
        $classNameSelect = null;
        foreach (ParserBotService::GetCharacterClasses() as $V) {
            if (basename($V) == $className) $classNameSelect = $V;
        }
        if (!$classNameSelect) dd("no classs");


        //dd(get_class_methods($classNameSelect));
        dd(get_class_vars($classNameSelect));

        $x = 1;
        return view("bot.virtual.character", compact(['x']));
    }

}
