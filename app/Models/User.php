<?php

namespace App\Models;

use App\Characters\PlayerCharacter;
use App\Models\Bot\Character;
use App\Models\Bot\Scene;
use app\Models\Trash\BasketItem;
use app\Models\Trash\Order;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $current_shop
 * @property int scene_id
 * @property Scene scene
 * @property string name
 * @property string message_last
 * @property int $id
 * @property int player_id
 * @property boolean is_registration_end
 * @property PlayerCharacter player
 * @property array|mixed $buttons
 * @property mixed $vk_id
 * @property int last_message_time
 */
class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    /**
     * Если пользователь новичек и только что зарегался
     * @return bool
     */
    public function IsFirstStepRegistration()
    {
        return $this->startStepCompleted <> 1;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'buttons' => 'array'
    ];


    public function scene()
    {
        return $this->belongsTo(Scene::class, "scene_id");
    }

    public function player()
    {
        return $this->belongsTo(PlayerCharacter::class, "player_id");
    }

    /**
     * @return Character[]
     */
    public function GetAllCharacters()

    {
        $list = [];
        foreach (Character::where("user_id", $this->id)->get() as $char) {
            $character = $char->className::LoadCharacterById($char->id);
            $character->ReCalc();
            $list[] = $character;
        }
        return $list;

    }
}
