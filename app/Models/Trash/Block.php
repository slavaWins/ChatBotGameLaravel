<?php

    namespace app\Models\Trash;

    use app\Models\Trash\BaseRow;
    use app\Models\Trash\Project;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    /**
     * @property array parameters
     * @property string template_ind
     * @property int $id
     * @property int project_id
     * @property int parent_id
     * @property int row_id
     * @property Block parent
     * @property BaseRow row
     * @property int pos
     * @property string txt
     * @property Project $project
     */
    class Block extends Model
    {
        use HasFactory;

        public function row() {
            return $this->belongsTo(BaseRow::class, "row_id");
        }

        public function parent() {
            return $this->belongsTo(Block::class, "parent_id");
        }

        public function project() {
            return $this->belongsTo(Project::class, "project_id");
        }
    }
