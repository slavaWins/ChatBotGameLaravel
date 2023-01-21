<?php
namespace App\Scene\Virtual;

use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;

class GandonVirtualRoom extends BaseRoomPlus
{
    
    public function Step0_SelectEnginePartCharacter()
    {
        $this->response->Reset();
        
        $this->response->message = "Ок ты здесь";
        
        $example =  new \App\Characters\EnginePartCharacter();
        
        //selector_character_filter player
        
        $items = $this->user->GetAllCharacters(\App\Characters\EnginePartCharacter::class);
        
        $selectCharacter = $this->PaginateSelector($items);
        
        if (count($items) == 1) {
            //$selectCharacter = $this->items->first();
            } elseif (count($items) == 0) {
                $this->response->AddWarning($example->icon." ".$example->baseName.': 0 шт.');
            }
            
            if ($selectCharacter) {
                
                return $this->NextStep();
            }
            
            return $this->response;
        }
        
    } 