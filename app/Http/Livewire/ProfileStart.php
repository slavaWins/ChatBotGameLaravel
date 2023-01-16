<?php

    namespace App\Http\Livewire;

    use App\Http\Controllers\NotifyBallController;
    use app\Models\Trash\Project;
    use Livewire\Component;

    use MoveMoveIo\DaData\Enums\BranchType;
    use MoveMoveIo\DaData\Enums\CompanyType;
    use MoveMoveIo\DaData\Facades\DaDataCompany;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    class ProfileStart extends Component
    {
        public $step = 1;
        public $stepMax = 3;
        public $showError = null;
        public $typeProjectList;

        public        $projectId = 1;
        public        $projectToken = "ZXCBCBCB-ASFHHWFQW-FQWGWQWG";

        public $typeProject;
        public $projectName = "Proj1";
        private $project;
        public $isCanSkip = false;


        function resetInput()
        {
            $this->showError = null;
        }

        public function makeBack()
        {
            $this->resetInput();
            if ($this->step <= 1) return;
            $this->step -= 1;
        }


        public function makeStep3_Finish()
        {

            $user = User::find(Auth::user()->id);


            if ($user->startStepCompleted==0) {
                NotifyBallController::SendToUid(Auth::user()->id, "Добро пожаловать! Вы прошли стартове настройки и создали первый проект.");
                $user->startStepCompleted = 1;
                $user->save();
            } else {
                NotifyBallController::SendToUid(Auth::user()->id, "Новый проект успешно создан!");
            }


            return redirect()->route("projEdit", $this->projectId);
        }


        public function makeStep2yes($val)
        {
            $this->resetInput();
            if (!isset($this->typeProjectList[$val])) return;
            if ($this->step != 2) return;
            $this->step += 1;
            $this->typeProject = $val;


        }

        public function makeStep1()
        {
            $this->resetInput();

            if ($this->step != 1) return;
            $this->projectName = trim($this->projectName);

            if (mb_strlen($this->projectName) < 3) {
                $this->showError = "Не менее 3х символов!";

                return;
            }
            if (mb_strlen($this->projectName) > 22) {
                $this->showError = "Не более 22 символов!";

                return;
            }

            $user = User::find(Auth::user()->id);
            $user->name = "Пользователь";
            $user->save();

            $this->step += 1;
        }


        public function nextStep()
        {
            $this->step += 1;
        }


        public function render()
        {
        //    $this->typeProjectList = $typeProject = Project::$typeProject;

            if (!Auth::user()->IsFirstStepRegistration()) {
           //    $this->isCanSkip = true;
            }

            return view('livewire.profile-start');
        }
    }
