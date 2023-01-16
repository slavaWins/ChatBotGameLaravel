<?php

    namespace app\Http\Controllers\trash;


    use App\Actions\OpenHomePage;
    use App\Http\Controllers\Controller;
    use App\Models\Offer;
    use App\Models\ResponseApi;
    use app\Models\Trash\BaseRow;
    use app\Models\Trash\Block;
    use app\Models\Trash\Project;
    use App\Repositories\OperationsRepository;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;


    class EditorController extends Controller
    {


        public function show(Project $project) {
            $baserows = BaseRow::where("project_id", $project->id)->get();

            //dd(count($baserows));
            return view('editor.editor-show', compact('project', 'baserows'));
        }

        public function RemoveBaseRow(Request $request) {

            $validator = Validator::make($request->toArray(),
                [
                    //  'ind'        => 'required|string|min:2|max:32',
                    'baseRowId'  => 'required|int|min:1',
                    'project_id' => 'required|int|min:1',
                ]
            );

            if ($validator->fails()) {
                return ResponseApi::Error($validator->errors()->first());
            }


            $data = $validator->validate();

            $baseRow = BaseRow::find($data['baseRowId']);

            if ($baseRow->project_id <> $data['project_id']) {
                return ResponseApi::Error("Не тот проект");
            }
            $baseRow->delete();


            return ResponseApi::Successful();
        }

        public function BaseRowParametersUpdate(Request $request) {
            $validator = Validator::make($request->toArray(),
                [
                    'baseRowId'      => 'required|int|min:1',
                    'backgroundUrl'  => 'required|string|min:0',
                    'overlayOpacity' => 'required|int|min:0|max:100',
                    'paddingVertical' => 'required|int|min:0|max:500',
                    'textColor'      => 'required|string|min:6|max:7',
                    'overlayColor'   => 'required|string|min:6|max:7',
                    'project_id'     => 'required|int|min:1',
                ]
            );
            if ($validator->fails()) {
                return ResponseApi::Error($validator->errors()->first());
            }


            $data = $validator->validate();

            /** @var BaseRow $baseRow */
            $baseRow = BaseRow::find($data['baseRowId']);

            if ($baseRow->project_id <> $data['project_id']) {
                return ResponseApi::Error("Не тот проект");
            }

            $baseRow->backgroundUrl = $data['backgroundUrl'];
            $baseRow->overlayOpacity = $data['overlayOpacity'];
            $baseRow->paddingVertical = $data['paddingVertical'];
            $baseRow->textColor = $data['textColor'];
            $baseRow->overlayColor = $data['overlayColor'];
            $baseRow->save();

            return ResponseApi::Successful();
        }

        public function TextareaUpdates(Request $request) {
            $validator = Validator::make($request->toArray(),
                [
                    'project_id' => 'required|int|min:1',
                ]
            );
            if ($validator->fails()) {
                return ResponseApi::Error($validator->errors()->first());
            }


            $data = $validator->validate();

            $textaraeForSaveData = $request->toArray()['textaraeForSaveData'];

            if(empty($textaraeForSaveData)){
                return ResponseApi::Error("Нет текстовых изменений!");
            }

            foreach ($textaraeForSaveData as $id => $val) {
                /** @var Block $block */
                $block = Block::find($id);
                if (!$block)return ResponseApi::Error("Не найден блок! ".$id);
                if ($block->project_id <> $data['project_id']) return ResponseApi::Error("Не подоходит к проекту!");
                $block->txt = $val;
                $block->save();
            }

            return ResponseApi::Successful();
        }

        public function MapSortBlocksUpdates(Request $request) {
            $validator = Validator::make($request->toArray(),
                [
                    'project_id' => 'required|int|min:1',
                ]
            );
            if ($validator->fails()) {
                return ResponseApi::Error($validator->errors()->first());
            }


            $data = $validator->validate();

            $mapSortData = $request->toArray()['mapSortData'];

            if(empty($mapSortData)){
                return ResponseApi::Error("Нет текстовых изменений!");
            }

            foreach ($mapSortData as $id => $val) {
                /** @var Block $block */
                $block = Block::find($id);
                if (!$block)return ResponseApi::Error("Не найден блок! ".$id);
                if ($block->project_id <> $data['project_id']) return ResponseApi::Error("Не подоходит к проекту!");
                if($block->pos==$val)continue;
                $block->pos = $val;
                $block->save();
            }

            return ResponseApi::Successful();
        }

        public function AddBaseRow(Request $request) {

            $validator = Validator::make(
                $request->toArray(),
                [
                    //  'ind'        => 'required|string|min:2|max:32',
                    'baseRowId'  => 'required|int|min:1',
                    'posType'    => 'required|string',
                    'project_id' => 'required|int|min:1',
                    'pos'        => 'required|int',
                ],
                [
                ],
                [
                    'name' => 'Название',
                ]
            );

            if ($validator->fails()) {
                return ResponseApi::Error($validator->errors()->first());
            }


            $data = $validator->validate();

            $baseRow = new BaseRow();
            $baseRow->project_id = $data['project_id'];
            $baseRow->template_ind = "container";
            $baseRow->parent_id = 0;
            $baseRow->pos = $data['pos'];
            $baseRow->save();

            return ResponseApi::Successful();
        }

        public function BlockAdd(Request $request) {


            $validator = Validator::make(
                $request->toArray(),
                [
                    'ind'        => 'required|string|min:1|max:32',
                    'row_id'  => 'required|int|min:1|max:32',
                    'pos'        => 'required|int|min:-1000',
                    'project_id' => 'required|int',
                ],
                [
                ],
                [
                    'name' => 'Название',
                ]
            );

            if ($validator->fails()) {
                return ResponseApi::Error($validator->errors()->first());
            }

            $data = $validator->validate();

            $block = new Block();
            $block->project_id = $data['project_id'];
            $block->template_ind = $data['ind'];
            $block->row_id = $data['row_id'];
            $block->pos = $data['pos'];
            $block->txt = "Новый блок!!!";
            $block->save();

            return ResponseApi::Successful();
        }

        public function store(Request $request) {
            $validator = Validator::make(
                $request->toArray(),
                [
                    'name' => 'required|string|min:2|max:32',
                ],
                [
                ],
                [
                    'name' => 'Название',
                ]
            );

            $data = $validator->validate();


            $project = new Project();
            $project->name = $data['name'];
            $project->user_id = Auth::user()->id;

            $res = $project->save();

            if (!$res) {
                return redirect()->back()->withErrors(['Ошибка создания, попробуйте позже'])->withInput();
            }

            return redirect(route("project.show", $project));
        }


    }
