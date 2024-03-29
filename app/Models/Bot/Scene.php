<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user_id
 * @property int|mixed $className
 * @property int|mixed $step
 * @property int timer_from
 * @property int $timer_to
 * @property array|mixed $sceneData
 * @property mixed $id
 * @property mixed|true $debug_play
 */
class Scene extends Model
{
    use HasFactory;

    /**
     * @var int|mixed
     */

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
