<?php

namespace App\Models;

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
}
