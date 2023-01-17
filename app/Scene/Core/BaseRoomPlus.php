<?php

namespace App\Scene\Core;

use App\Characters\CarCharacter;
use App\Helpers\PaginationHelper;
use App\Library\Structure\BotResponseStructure;
use App\Scene\HomeRoom;

class BaseRoomPlus extends BaseRoom
{

    /**
     * Вывести пагинированый список моих чарактеров по их классу. С кнопкой. И переходм на другой шаг. С кнопкой выхода в хоум.
     * Дополнительные кнопки и контент лучше добавлять перед функцией, иначе контент будет перенесен на другой шаг
     * @param $characterClass
     * @param $title
     * @param $moveToStep
     * @param $exitBtn
     * @return BotResponseStructure|mixed
     */
    public function RenderMyCharactersList($characterClass, $title = "Мои предметы", $moveToStep = 1, $exitBtn = "Назад")
    {
        /** @var CarCharacter[] $items */
        $items = $this->user->GetAllCharacters($characterClass);

        $this->response->message .= $title . " (" . (count($items)) . " шт): \n";

        $isRedirect = $this->PaginateCollection(collect($items), 4, function ($item) use ($moveToStep) {
            $this->response->message .= "\n\n" . $item->Render(true, false, false);

            if ($moveToStep) {
                if ($this->AddButton($item->name ?? $item->baseName)) {
                    $this->scene->SetData('id', $item->id);
                    $this->scene->save();
                    return $this->SetStep($moveToStep);
                }
            }

        });

        if ($isRedirect) return $isRedirect;

        if ($exitBtn) {
            if ($this->AddButton($exitBtn)) {
                return $this->SetRoom(HomeRoom::class);
            }
        }

        return $this->response;
    }


    public function PaginateCollection($listCollection, $inPage, $callback)
    {
        if (!isset($this->scene->sceneData['page'])) {
            $this->scene->SetData('page', 1);
            $this->scene->save();
        }

        $pageCurent = $this->scene->sceneData['page'];
        $pageCountMax = ceil($listCollection->count() / $inPage);

        $paginated = PaginationHelper::paginate($listCollection, $inPage, $pageCurent);

        foreach ($paginated as $item) {
            $response = $callback($item);
            if (is_object($response)) {
                if (substr_count(get_class($response), "BotResponseStructure")) {
                    // $this->response->Reset();
                    $this->request->message = "";
                    return $response;
                }
            }
        }

        if ($pageCountMax > 1) {
            if ($pageCurent > 1) {
                if ($this->AddButton("<")) {
                    $this->scene->SetData('page', $pageCurent - 1);
                    $this->scene->save();
                    $this->response->Reset();
                    $this->request->message = "";
                    return $this->Handle();
                }
            }
        }


        if ($pageCountMax > 1) {
            if ($pageCurent < $pageCountMax) {
                if ($this->AddButton(">")) {
                    $pageCurent += 1;
                    $this->scene->SetData('page', $pageCurent);
                    $this->scene->save();
                    $this->response->Reset();
                    $this->request->message = "";
                    return $this->Handle();
                }
            }
            $this->response->message .= "\n\n Страница " . ($pageCurent) . " / " . ($pageCountMax) . "";
        }

        return null;
    }

}
