<?php

namespace App\Jobs;

use App\Events\CheckUpdateEvent;
use App\Girl;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use VK\Client\VKApiClient;

class CheckUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 8000;
    public $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $girls = Girl::all();
        $girls_count = Girl::all()->count();
        $count = ceil($girls_count/1000);

        $vk = new VKApiClient();
        $access_token = $this->token;

        $offset = 0;
        $counter = 0;
        for ($i = 0; $i < $count; ++$i) {
            $girl_list = $girls->slice($offset, 1000);
            $profilesId = [];
            foreach($girl_list as $girl) {
                $removeChar = ["https://", "http://", "/", 'vk.com', 'id'];
                $girl_id = str_replace($removeChar, "", $girl->url);
                $profilesId[] = $girl_id;
            }

            $getInfoUser = $vk->users()->get($access_token, array(
                'user_ids' => $profilesId,
                'fields' => 'photo_200,city,sex,bdate,last_seen'
            ));
            foreach ($getInfoUser as $user) {
                if (isset($user['last_seen']['time'])) {
                    $girl_new = Girl::where('url', 'like', '%'.$user['id'])->first();
                    $girl_new->last_seen = Carbon::createFromTimestamp($user['last_seen']['time'])->addHours(2)->format('d.m.Y H:i');
                    $girl_new->save();
                }
                ++$counter;
                event(new CheckUpdateEvent($counter));
            }
            $offset += 1000;
        }
    }
}
