<?php

    namespace app\Models\Trash;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    /**
     * @property array parameters
     * @property string template_ind
     * @property int $id
     * @property int project_id
     * @property int parent_id
     * @property Block parent
     * @property int pos
     * @property int overlayOpacity
     * @property int paddingVertical
     * @property string $backgroundUrl
     * @property string textColor
     * @property string backgroundColor
     * @property string overlayColor
     * @property Project $project
     */
    class BaseRow extends Model
    {
        use HasFactory;


        /**
         * @return Block[]
         */
        public function GetBlocks() {
            return Block::where("project_id", $this->project_id)->where("row_id", $this->id)->orderBy('pos')->get();
        }

        public function parent() {
            return $this->belongsTo(Block::class, "parent_id");
        }

        public function project() {
            return $this->belongsTo(Project::class, "project_id");
        }
    }
