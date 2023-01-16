<?php

    namespace app\Models\Trash;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    /**
     * @property string $name
     * @property string domain
     * @property string font_h
     * @property string font_text
     * @property string robotstxt
     * @property string favicon
     * @property int $id
     * @property int $user_id
     * @property User $user
     * @property boolean is_shop
     */
    class Project extends Model
    {
        use HasFactory;


        public function user() {
            return $this->belongsTo(User::class, "user_id");
        }

    }
