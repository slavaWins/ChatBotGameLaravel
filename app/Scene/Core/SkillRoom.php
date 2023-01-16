<?php

namespace App\Scene\Core;

use App\Characters\PlayerCharacter;
use App\Library\Structure\BotRequestStructure;
use App\Models\Bot\Character;
use App\Models\User;
use App\Scene\BaseRoom;
use App\Scene\HomeRoom;
use Illuminate\Support\Facades\Validator;

class SkillRoom extends BaseRoom
{

    /** @var Character $character */
    public $character;

    public function Step0()
    {
        $this->response->Reset();
        $this->user->player->ReCalc();
        $this->character->ReCalc();

        $this->response->message = $this->user->player->GetStats()->money->RenderLine(true, false);
        $this->response->message .= ' ' . $this->user->player->GetStats()->score_level->RenderLine(true, false);

        $this->response->message .= "\n " . $this->character->icon . " " . $this->character->baseName . ". Улучшения:";

        foreach ($this->character->GetStats() as $ind => $data) {
            if (!substr_count($ind, "skill_")) continue;
            $this->response->message .= "\n\n" . $data->RenderLine(false, true);
            $priceData = $this->character->GetSkillPrice($ind, $data->value);
            if ($data->value < $data->max ?? 1111) {
                $this->response->message .= "\n  Улучшить за: ";

                //Выводим требования и чекаем их
                $isCanPay = true;
                $countNeededSkill = 0;
                foreach ($priceData as $K => $V) {
                    if ($K == 'money' || $K == 'score_level') { //эти параметры встроены в игрока
                        if ($countNeededSkill) $this->response->message .= ' + ';
                        $this->response->message .= $this->user->player->GetStats()->$K->RenderLine(true, false, $V);
                        $countNeededSkill++;
                        if ($this->user->player->characterData->$K < $V) $isCanPay = false;
                    }
                }

                //если требования не очень выводим
                if (!$isCanPay) {
                    $this->response->message .= " | Не хватает средств";
                } elseif ($this->AddButton($data->icon . ' ' . $data->name)) {
                    //если требования выполнены предлагаем кнопку
                    foreach ($priceData as $K => $V) {
                        if ($K == 'money' || $K == 'score_level') { //эти параметры встроены в игрока
                            $this->user->player->characterData->$K -= $V;
                        }
                        $this->character->characterData->$ind +=1;

                        $this->character->save();
                        $this->user->player->refresh();
                        $this->user->player->save();

                        $this->request->message = "";
                        $this->response = $this->Handle();
                        $this->response->AddWarning($data->icon . ' ' . $data->name . ' +1', "✅");
                        return $this->response;
                    }
                }
            }
        }


        if ($this->AddButton("Выход")) {
            return $this->SetRoom(HomeRoom::class);
        }

        return $this->response;
    }


    public function Handle()
    {
        $this->character = Character::LoadCharacterById($this->scene->sceneData['character_id']);

        if ($this->GetStep() == 0) return $this->Step0();

        return $this->response;
    }

    public static function CreateSkillRoomByCharacter(User $user, $character): SkillRoom
    {

        $request = new BotRequestStructure();
        $request->user = $user;
        $request->user_id = $user->id;
        $skillRoom = new SkillRoom($request);
        $skillRoom->scene->sceneData = ['character_id' => $character->id];

        $skillRoom->scene->save();
        $skillRoom->scene->refresh();
        return $skillRoom;
    }


}
