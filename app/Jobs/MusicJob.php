<?php

namespace App\Jobs;

use App\Chicken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use VK\Client\VKApiClient;

class MusicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $id;
    public $music;
    public $access_token;

    public function __construct($id, $music, $access_token)
    {
        $this->id = $id;
        $this->music = $music;
        $this->access_token = $access_token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $vk = new VKApiClient();
        $getInfoUser = $vk->users()->get($this->access_token, array(
            'user_ids' => $this->id,
            'fields' => 'photo_200,city,sex,bdate,last_seen'
        ));

        foreach ($getInfoUser as $girl) {
            $find_girl = Chicken::where('url', 'LIKE', '%'.$girl['id'])->first();
            if (!$find_girl) {
                $new_girl = new Chicken();
                $new_girl->url = 'https://vk.com/id'.$girl['id'];
                $new_girl->first_name = $girl['first_name'];
                $new_girl->last_name = $girl['last_name'];
                $new_girl->photo = $girl['photo_200'];
                if (isset($girl['last_seen'])) {
                    $new_girl->last_seen = $girl['last_seen']['time'];
                }
                else {
                    $new_girl->last_seen = '---';
                }
                if (isset($girl['bdate'])) {
                    $new_girl->bdate = $girl['bdate'];
                }
                else {
                    $new_girl->bdate = '---';
                }

                $new_girl->save();

                $lala = DB::table('chicken_note')
                    ->where('note_id',$this->music->id)
                    ->where('chicken_id',$new_girl->id)
                    ->first();
                if (!$lala) {
                    $new_girl->notes()->attach($this->music);
                }
            }
            else {
                $lala = DB::table('chicken_note')
                    ->where('note_id',$this->music->id)
                    ->where('chicken_id',$find_girl->id)
                    ->first();
                if (!$lala) {
                    $find_girl->notes()->attach($this->music);
                }
            }
        }
    }
}
