<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Http\Controllers\PusherMaker;
use Illuminate\Support\Facades\DB;

class SendNotifyBell implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uid;
    protected $title;
    protected $route;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uid, $title = "У вас новое уведомление. Похоже стоит его проверить.", $route=null)
    {
        $this->uid=$uid;
        $this->title=$title;
        $this->route=$route;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table("notyfy")->insert([
            'uid' => $this->uid,
            'title' => $this->title,
            'route' => $this->route,
            'isOpen' => false,
            'created_at' => Carbon::now(),
        ]);


        event(new PusherMaker($this->title, "notify_" . $this->uid));

    }
}
