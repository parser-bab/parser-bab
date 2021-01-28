<?php

namespace App\Jobs;

use App\Events\TaskUpdated;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use VK\Client\VKApiClient;

class StartTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $task;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        //dd($this->task);
//        $access_token = $this->task->vk_token;
//
//        $group = $this->task->url_group;
//        $removeChar = ["https://", "http://", "/", 'vk.com'];
//        $groupName = str_replace($removeChar, "", $group);
//
//
//        $numberPosts = $this->task->number_posts;
//
//        $vk = new VKApiClient();
//        $owner = $vk->groups()->getById($access_token, array(
//            'group_ids' => $groupName
//        ));
//        $groupNameForList = $owner[0]['name'];
//
//        $groupId = $owner[0]['id'];
//        $postsId = [];
//
//        echo '1';
//        sleep(10);
//        echo '2';
//        sleep(2);
        for ($x = 0; $x <= 100; $x+=10) {
            event(new TaskUpdated($x));
            $this->task->progress = $x;
            $this->task->save();
        }
    }
}
