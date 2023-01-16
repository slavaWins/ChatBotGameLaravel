<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Counter extends Component
{

    public $search = 'Test';
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {


        //$operations = DB::table("operations")   ->where('uid', Auth::user()->id)->orderByDesc("created_at")->get();

        return view('livewire.counter', [
            'users' => User::where('name', $this->search)->get(),
           // 'users' => $operations,
            'searchVal' => $this->search,
        ]);

       // return view('livewire.counter');
    }
}
