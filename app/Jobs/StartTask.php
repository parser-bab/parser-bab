<?php

namespace App\Jobs;

use App\Events\NumberPost;
use App\Events\TaskUpdated;
use App\Girl;
use App\Group;
use App\Post;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use VK\Client\VKApiClient;
use function MongoDB\BSON\toJSON;

class StartTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 8000;
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
        //dd($this->task);
        /**
         * Получение ссылки
         * Получение имя группы
         * Получение количества постов
         */
        $access_token = $this->task->vk_token;

        $group = $this->task->url_group;
        $removeChar = ["https://", "http://", "/", 'vk.com'];
        $groupName = str_replace($removeChar, "", $group);
        $numberPosts = $this->task->number_posts;


        /**
         * Получение информации о группе
         * Название и айди
         */
        $vk = new VKApiClient();
        $owner = $vk->groups()->getById($access_token, array(
            'group_ids' => $groupName
        ));

        $groupNameForList = $owner[0]['name'];
        $groupId = $owner[0]['id'];
        $postsId = [];

        $data = Group::where('url_group', $this->task->url_group)->first();
        //dump($data);

        if(!$data) {
            $data = new Group();
            $data->url_group = $this->task->url_group;
            $data->title = $groupNameForList;
            $data->save();
        }

        //dd($data);
        /**
         * Получение списка постов
         * Получение списка айди каждого поста
         */
        $progress = 0;
        $cicles = ceil($numberPosts/100);
        $counter = $numberPosts;

        for ($offset = 0; $offset < $counter; $offset = $offset + 100) {

            $findAllPosts = $vk->wall()->get($access_token, array(
                'owner_id' => '-' . $groupId,
                'offset' => $offset,
                'count' => $numberPosts
            ));
            $first_time = microtime(true);
            echo 'Получение постов '.($offset+100).' // '.date('Y-m-d H:i:s').PHP_EOL;
            $postsList = $findAllPosts['items'];
            foreach ($postsList as $post) {
                $postsId [] = $post['id'];
            }
            $numberPosts = $numberPosts - 100;


            $circles = 33.33/$cicles;
            $progress += $circles;

            $this->task->progress = $progress;
            $this->task->save();
            event(new TaskUpdated($this->task->progress));
            $last_time = microtime(true);
            //dd($last_time - $first_time);
            $raznica = $last_time - $first_time;
            if($raznica >= 0.34) {
                continue;
            }
            else {
                usleep(340000 - $raznica);
            }
        }


        //dd($postsId);

        $profilesId = '';
        //$likesList = [];
        $i = 1;
        $findUserByCity = [];
        $findedUser = [];


        $cicles2 = 33.33/count($postsId);
        /**
         * Перебор каждого поста
         * Получение списка лайкнувших пост
         */
        foreach ($postsId as $postId) {

            //echo 'Пост ' . $i . '/' . count($postsId).' // '.date('Y-m-d H:i:s').PHP_EOL;
            /**
             * Получение списка лайкнувших для поста
             */
            for ($offset = 0; $offset < 30000; $offset = $offset + 1000) {
                $first_time = microtime(true);
                $findAllLikes = $vk->likes()->getList($access_token, array(
                    'type' => 'post',
                    'owner_id' => '-' . $groupId,
                    'item_id' => $postId,
                    'filter' => 'likes',
                    'extended' => '1',
                    'count' => '1000',
                    'offset' => $offset
                ));


                //Список лайкнувших
                $likesList = $findAllLikes['items'];

                /**
                 * Получение айди юзеров и добавление в список
                 */
                foreach ($likesList as $likeList) {
                        if ($likeList == end($likesList) and $postId == end($postsId)) {
                            $profilesId .= $likeList['id'];
                            break;
                        }
                        $profilesId .= $likeList['id'] . ',';
                }

                //sleep(1);



                $last_time = microtime(true);
                $raznica = $last_time - $first_time;
                if($raznica < 0.34) {
                    usleep(340000 - $raznica);
                }

                if (count($findAllLikes['items']) == 0) {
                    break;
                }



                $first_time = microtime(true);

                $getInfoUser = $vk->users()->get($access_token, array(
                    'user_ids' => $profilesId,
                    'fields' => 'photo_200,city,sex,bdate'
                ));



                $findUserByCity = $this->getBabs($getInfoUser, $groupId, $groupNameForList);

                foreach ($findUserByCity as $finded) {
                    $finded['post'] = 'http://vk.com/wall-'.$groupId.'_'.$postId;
                    $findedUser [] = $finded;
                }

                $profilesId = '';
                $likesList = [];

                $last_time = microtime(true);
                $raznica = $last_time - $first_time;
                if($raznica < 0.34) {
                    usleep(340000 - $raznica);
                }

            }

            $postData = Post::where('url', 'http://vk.com/wall-'.$groupId.'_'.$postId)->first();
            if (!$postData) {
                $postData = new Post();
                $postData->url = 'http://vk.com/wall-'.$groupId.'_'.$postId;
                $postData->save();
            }


            ++$i;
            $likesList = [];

            $progress += $cicles2;

            $this->task->progress = $progress;
            $this->task->save();
            event(new TaskUpdated($this->task->progress));

            //sleep(1);
        }


        //$finalResult = array_unique($findedUser, SORT_REGULAR);
        $finalResult = $findedUser;
        $this->task->number_girls = count($finalResult);
        $this->task->save();

//        echo 'Найдено: '.count($finalResult).' пользователей.'.' // '.date('Y-m-d H:i:s').PHP_EOL;

//        echo 'Началась запись в базу данных.'.' // '.date('Y-m-d H:i:s').PHP_EOL;
        $cicles3 = 0;
        if(count($finalResult) === 0) {
            $this->task->progress = 100;
            $this->task->save();
            event(new TaskUpdated($this->task->progress));
        }
        else {
            $cicles3 = 33.34/count($finalResult);
        }

        foreach ($finalResult as $result) {
//            echo 'Запись '.$i.'/'.count($finalResult).' // '.date('Y-m-d H:i:s').PHP_EOL;

            $progress += $cicles3;
            $this->task->progress = $progress;
            $this->task->save();
            event(new TaskUpdated($this->task->progress));

            //dd(!(Girl::where('url', 'http://vk.com/id'.$result['id']))->first());
            if(!(Girl::where('url', 'http://vk.com/id'.$result['id']))->first()) {
                $girl = new Girl();
                $girl->url = 'http://vk.com/id'.$result['id'];
                $girl->first_name = $result['first_name'];
                $girl->last_name = $result['last_name'];
                if (isset($result['bdate'])) {
                    $girl->bdate = $result['bdate'];
                }
                else {
                    $girl->bdate = '---';
                }
                $girl->photo = $result['photo'];
                $girl->group = $result['group'];
                $girl->group_name = $result['group_name'];
//            $girl->posts = toJson('aala');
                $girl->save();
                $girl->groups()->attach($data);

//                $table = DB::table('girl_group')
//                    ->where('girl_id',$girl->id)
//                    ->where('group_id',$data->id)
//                    ->get();
//                if(!$table) {
//                    $girl->groups()->attach($data);
//                }
                $postData = Post::where('url', $result['post'])->first();
                if (!$postData) {
                    $postData = new Post();
                    $postData->url = $result['post'];
                    $postData->save();
                    $girl->posts()->attach($postData);
                }
                else {
                    //$postData = Post::where('url', $result['post'])->first();
                    $lala = DB::table('girl_post')
                        ->where('girl_id',$girl->id)
                        ->where('post_id',$postData->id)
                        ->first();
                    if (!$lala) {
                        $girl->posts()->attach($postData);
                    }
                }

            }
            else {
                $girl = Girl::where('url', 'http://vk.com/id'.$result['id'])->first();
                $table = DB::table('girl_group')
                    ->where('girl_id',$girl->id)
                    ->where('group_id',$data->id)
                    ->first();
                if(!$table) {
                    $girl->groups()->attach($data);
                }
                //dd();
                $postData = Post::where('url', $result['post'])->first();
                if (!$postData) {
                    $postData = new Post();
                    $postData->url = $result['post'];
                    $postData->save();
                    $girl->posts()->attach($postData);
                }
                else {
                    //$postData = Post::where('url', $result['post'])->first();
                    $lala = DB::table('girl_post')
                        ->where('girl_id',$girl->id)
                        ->where('post_id',$postData->id)
                        ->first();
                    if (!$lala) {
                        $girl->posts()->attach($postData);
                    }
                }
            }




//            $girl = new Girl();
//            $girl->url = 'https://vk.com/id'.$result['id'];
//            $girl->first_name = $result['first_name'];
//            $girl->last_name = $result['last_name'];
//            if (isset($result['bdate'])) {
//                $girl->bdate = $result['bdate'];
//            }
//            else {
//                $girl->bdate = '---';
//            }
//            $girl->photo = $result['photo'];
//            $girl->group = $result['group'];
//            $girl->group_name = $result['group_name'];
////            $girl->posts = toJson('aala');
//            $girl->save();
//            $girl->groups()->attach($data);
            ++$i;
        }
        $this->task->progress = 100;
        $this->task->save();
//        echo 'Запись успешно завершена.'.' // '.date('Y-m-d H:i:s').PHP_EOL;

    }


    private function getBabs(array $getInfoUser, $ownerId, $groupNameForList)
    {
        //dd($groupNameForList);
        $end = [];
        foreach ($getInfoUser as $infoUser) {

            //dd($getInfoUser);
            if (!isset($infoUser['city'])) {
                continue;
            }
            //650
            //2256
            if ($infoUser['sex'] == 1 and $infoUser['city']['id'] == 650) {
                if (isset($infoUser['bdate'])) {
                    $end [] = [
                        'id' => $infoUser['id'],
                        'is_closed' => $infoUser['is_closed'],
                        'first_name' => $infoUser['first_name'],
                        'last_name' => $infoUser['last_name'],
                        'bdate' => $infoUser['bdate'],
                        'photo' => $infoUser['photo_200'],
                        'group_name' => $groupNameForList,
                        'group' => 'https://vk.com/public'.$ownerId
                    ];
                }
                else {
                    $end [] = [
                        'id' => $infoUser['id'],
                        'is_closed' => $infoUser['is_closed'],
                        'first_name' => $infoUser['first_name'],
                        'last_name' => $infoUser['last_name'],
                        'photo' => $infoUser['photo_200'],
                        'group_name' => $groupNameForList,
                        'group' => 'https://vk.com/public'.$ownerId
                    ];
                }

                //dd($end);
            }
        }

        return $end;
    }

}
