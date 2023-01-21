<?php
namespace App\Scene\Virtual;

use App\Characters\CarCharacter;
use App\Characters\EnginePartCharacter;
use App\Scene\Core\BaseRoomPlus;

//Это класс комнаты, наследованый от базовой комнаты. В базовой есть наборы функций. Кнопки, пагниаторы, всё для быстроботоводни
class GandonVirtualRoom extends BaseRoomPlus
{
    
    
    public function Step0_step()
    {
        //Очищаем овет от кнопок и текста
        $this->response->Reset();
        
        $this->response->message = "Ок ты здесь";
        
        
        //Эта штука проверяет, была ли нажата пользователем кнопка. И в то же время эту кнопку сам создает
        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
        }
        
        
        //Возвращаем ответ, который удет пользователю. В нем кнопки и текст
        return $this->response;
    }
    
    
    //Эта функция вызывается при загрузки сцены
    function Boot()
    {
        if ($this->scene->sceneData['id'] ?? false) {
        }
        
    }
    
    
} 