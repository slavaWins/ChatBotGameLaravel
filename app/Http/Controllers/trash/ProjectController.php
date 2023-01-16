<?php

    namespace app\Http\Controllers\trash;


    use App\Actions\OpenHomePage;
    use App\Http\Controllers\Controller;
    use App\Models\Offer;
    use app\Models\Trash\Project;
    use App\Repositories\OperationsRepository;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;


    class ProjectController extends Controller
    {


        public function create() {
            return view('project.project-create');
        }

        public function show(Project $project) {
            return view('project.project-show',compact('project'));
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
