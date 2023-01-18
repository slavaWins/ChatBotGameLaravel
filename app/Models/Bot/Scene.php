<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user_id
 * @property int|mixed $className
 * @property int|mixed $step
 * @property array|mixed $sceneData
 * @property mixed $id
 */
class Scene extends Model
{
    use HasFactory;

    protected $casts = [
        'sceneData' => 'array'
    ];

    public function SetData($key, $val)
    {
        $data = $this->sceneData;
        $data[$key] = $val;
        $this->sceneData = $data;
        return $this;
    }
}
