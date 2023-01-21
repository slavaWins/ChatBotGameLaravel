<?php
namespace App\Scene\Virtual;

use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;

class GavnoVirtualRoom extends BaseRoomPlus
{
    
    public ?\App\Characters\GarageCharacter $garage;
    
    public ?\App\Characters\CarCharacter $car;
    
    
    public function Step0_SelectGarageCharacter()
    {
        $this->response->Reset();
        
        $this->response->message = "Выберите гараж";
        
        
        //render_character: not
        
        
        $example =  new \App\Characters\GarageCharacter();
        
        //selector_character_filter player
        
        $items = $this->user->GetAllCharacters(\App\Characters\GarageCharacter::class);
        
        $selectCharacter = $this->PaginateSelector($items);
        
        if (count($items) == 1) {
            //$selectCharacter = $this->items->first();
            } elseif (count($items) == 0) {
                $this->response->AddWarning($example->icon." ".$example->baseName.': 0 шт.');
            }
            
            if ($selectCharacter) {
                
                $this->scene->SetData('id', $selectCharacter->id);
                $this->scene->save();
                
                
                return $this->NextStep();
            }
            
            
            if ($this->AddButton("Домой")) {
                return $this->SetRoom(\App\Scene\HomeRoom::class, ['id'=>$this->car->id]);
            }
            
            //step->btn_shop_parent = not
            if ($this->AddButton("Купить гараж")) {
                $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  \App\Characters\Shop\GarageItemCharacterShop::class);
                
                
                return $this->SetRoom($room, null, true);
                
            }
            
            if ($this->AddButton("Выход")) {
                $this->DeleteRoom();
                return null;
            }
            
            
            return $this->response;
        }
        public function Step1_SelectCarCharacter()
        {
            $this->response->Reset();
            
            $this->response->message = "Вы смотрите гараж";
            
            
            //render_character: var1
            $this->response->message .="\n" .     $this->garage->Render();
            
            
            $example =  new \App\Characters\CarCharacter();
            
            //selector_character_filter player_parentRoomCharacter1
            
            $items = $this->user->GetAllCharacters(\App\Characters\CarCharacter::class);
            $items= $items->filter(function($item){
                return $item->parent_id == $this->garage->id;
                });
                
                $selectCharacter = $this->PaginateSelector($items);
                
                if (count($items) == 1) {
                    //$selectCharacter = $this->items->first();
                    } elseif (count($items) == 0) {
                        $this->response->AddWarning($example->icon." ".$example->baseName.': 0 шт.');
                    }
                    
                    if ($selectCharacter) {
                        
                        
                        $this->scene->SetData('id2', $selectCharacter->id);
                        $this->scene->save();
                        
                        return $this->NextStep();
                    }
                    
                    
                    //step->btn_shop_parent = var1
                    if ($this->AddButton("Купить машину")) {
                        
                        $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  \App\Characters\Shop\CarItemCharacterShop::class, $this->garage->id);
                        
                        return $this->SetRoom($room, null, true);
                        
                    }
                    
                    if ($this->AddButton("Выход")) {
                        $this->DeleteRoom();
                        return null;
                    }
                    
                    if ($this->AddButton("Другой гараж")) {
                        return $this->PrevStep();
                    }
                    
                    
                    return $this->response;
                }
                public function Step2_Showvar2()
                {
                    $this->response->Reset();
                    
                    $this->response->message = "Что сделать с машиной?";
                    
                    
                    //render_character: var2
                    $this->response->message .="\n" .   $this->car->Render();
                    
                    
                    if ($this->AddButton("На СТО")) {
                        return $this->SetRoom(\App\Scene\StoRoom::class, ['id'=>$this->car->id]);
                    }
                    
                    //step->btn_shop_parent = var2
                    if ($this->AddButton("Купить запчасти")) {
                        
                        
                        $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  \App\Characters\Shop\EnginePartShop::class, $this->car->id);
                        return $this->SetRoom($room, null, true);
                        
                    }
                    
                    
                    if ($this->AddButton("Другая машина")) {
                        return $this->NextStep();
                    }
                    
                    return $this->response;
                }
                
                function Boot()
                {
                    
                    if ($this->scene->sceneData['id'] ?? false) {
                        
                        $this->garage = \App\Characters\GarageCharacter::LoadCharacterById($this->scene->sceneData['id']);
                        
                    }
                    
                    if ($this->scene->sceneData['id2'] ?? false) {
                        
                        $this->car = \App\Characters\CarCharacter::LoadCharacterById($this->scene->sceneData['id2']);
                        
                    }
                    
                }
                
            } 