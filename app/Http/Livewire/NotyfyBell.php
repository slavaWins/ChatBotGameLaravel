<?php

    namespace App\Http\Livewire;

    use Illuminate\Support\Facades\DB;
    use Livewire\Component;
    use Illuminate\Support\Facades\Auth;

    class NotyfyBell extends Component
    {
        public $list;
        public $countNew;
        public $userId;

        protected $listeners =
            [
                'UpdData' => 'UpdData',
                'OpenAllNotify' => 'OpenAllNotify'
            ];

        public function OpenAllNotify() {
            $this->countNew=0;
            DB::table("notyfy")
                ->where("isOpen", 0)
                ->where("uid", Auth::user()->id)
                ->update(['isOpen'=> 1]);
        }

        public function UpdData() {
           $this->countNew+=1;
        }

        public function render() {
            $this->countNew = 0;
            $this->userId = Auth::user()->id;
            $this->list = DB::table("notyfy")->where("uid", Auth::user()->id)
                ->orderByDesc('created_at')
                ->get();

            foreach ($this->list as $key =>$item){
               // dd($item);
                if($item->isOpen==0){
                    $this->countNew += 1;
                }
            }

            return view('livewire.notyfy-bell');
        }
    }
