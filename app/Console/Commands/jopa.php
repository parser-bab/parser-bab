<?php


namespace App\Console\Commands;

use App\cyka;
use App\Girl;
use App\Http\Controllers\ApiController;
use Illuminate\Console\Command;
use VK\Client\VKApiClient;
use VK\Exceptions\VKClientException;
use VK\Exceptions\VKOAuthException;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class jopa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bab:add {group} {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $group = $this->input->getArgument('group');
        $removeChar = ["https://", "http://", "/", 'vk.com'];
        $groupName = str_replace($removeChar, "", $group);


        $count = $this->input->getArgument('count');
        /**
         * @var VKOAuth @oauth
         */
        $oauth = new VKOAuth();
        $client_id = 7436120;

        $redirect_uri = 'http://127.0.0.1/second';
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
        $state = 'secret_state_code';


        //ПОЛУЧЕНИЕ ССЫЛКИ НА АВТОРИЗАЦИЮ
        $browser_url = urldecode($oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state));
        $browserURL = 'https://oauth.vk.com/authorize?client_id=7436120&redirect_uri=http://127.0.0.1/second&display=page&scope=270336&state=secret_state_code&response_type=code&v=5.101';

        $oauth = new VKOAuth();
        $client_id = 7436120;
        $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
        $redirect_uri = 'http://127.0.0.1/second';
        $code = '5342caa66761885263';

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        //$access_token = $response['access_token'];
        //dd($access_token);

        /**
         * ТОКЕН
         */
        $access_token = '0fd25bfabbef8e589f3d844dbcf07bc7ec5fdd3e1090bd476a4fb951ca980b128a10a3a0a6e42bcebdc80';
        /**
         * ТОКЕН
         */

        //АВТОРИЗАЦИЯ И АЙДИ ГРУППЫ
        $vk = new VKApiClient();

        $owner = $vk->groups()->getById($access_token, array(
            'group_ids' => $groupName
        ));
        $groupNameForList = $owner[0]['name'];

        $ownerId = $owner[0]['id'];

        //$ownerId = 27122967;

        //$postsList = [];
        $postsId = [];


        $counter = $count;
        for ($offset = 0; $offset < $counter; $offset = $offset + 100) {
            $findAllPosts = $vk->wall()->get($access_token, array(
                'owner_id' => '-' . $ownerId,
                'offset' => $offset,
                'count' => $count
            ));
            echo 'Получение постов '.($offset+100).' // '.date('Y-m-d H:i:s').PHP_EOL;
            $postsList = $findAllPosts['items'];
            foreach ($postsList as $post) {
                $postsId [] = $post['id'];
            }
            $count = $count - 100;
            sleep(1);
        }
        //dd(count($postsId));
        //ПОЛУЧЕНИЕ ВСЕХ ПОСТОВ
        //dd($postsId);
        //dd($postsList);



        //ПОЛУЧЕНИЕ ID ПОСТОВ


        //dd($postsId);

        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        $profilesId = '';
        $likesList = [];
        $i = 1;
        $findUserByCity = [];
        $findedUser = [];
        //ПОЛУЧЕНИЕ СПИСКА ЛАЙКНУВШИХ
        foreach ($postsId as $postId) {
            echo 'Пост ' . $i . '/' . count($postsId).' // '.date('Y-m-d H:i:s').PHP_EOL;
            for ($offset = 0; $offset < 30000; $offset = $offset + 1000) {
                $findAllLikes = $vk->likes()->getList($access_token, array(
                    'type' => 'post',
                    'owner_id' => '-' . $ownerId,
                    'item_id' => $postId,
                    'filter' => 'likes',
                    'extended' => '1',
                    'count' => '1000',
                    'offset' => $offset
                ));

                //dd($findAllLikes);
                //echo count($profilesLikeListAll['items']).'<br>';
                //dd($profilesLikeListAll);
                if (count($findAllLikes['items']) == 0) {
                    break;
                }
                $likesList [] = $findAllLikes['items'];


                foreach ($likesList as $likeList) {
                    foreach ($likeList as $like) {
                        if ($like == end($likeList) and $postId == end($postsId)) {
                            $profilesId .= $like['id'];
                            break;
                        }
                        $profilesId .= $like['id'] . ',';

                    }
                }

                sleep(0.1);
                $getInfoUser = $vk->users()->get($access_token, array(
                    'user_ids' => $profilesId,
                    'fields' => 'photo_200,city,sex,bdate'
                ));
                //dd($getInfoUser);

                $findUserByCity = $this->getBabs($getInfoUser, $ownerId, $groupNameForList);


                foreach ($findUserByCity as $finded) {
                    $findedUser [] = $finded;
                }

                $profilesId = '';
                $likesList = [];

            }


            ++$i;
            $likesList = [];
            sleep(0.1);

        }

        //dd($profilesId);
        //вот это вставитьвцикл вверху


        //dd($getInfoUser);

        $i = 1;
        $finalResult = array_unique($findedUser, SORT_REGULAR);
        echo 'Найдено: '.count($finalResult).' пользователей.'.' // '.date('Y-m-d H:i:s').PHP_EOL;

        //dd($findedUser);
        //ПОЛУЧЕНИЕ ПОСТОВ, КОТОРЫЕ ЛАЙКНУЛИ
        /*$response = '';

        foreach ($findedUser as &$user) {
            echo 'Обработка пользователей: '.$i.' из '.count($findedUser).'.'.PHP_EOL;
            foreach ($postsId as $post) {
                if ($user['is_closed'] == true) {
                    continue;
                }
                $findLikedPostByUser = $vk->likes()->isLiked($access_token, array(
                    'user_id' => $user['id'],
                    'type' => 'post',
                    'owner_id' => '-'.$ownerId,
                    'item_id' => $post
                ));
                if ($findLikedPostByUser['liked'] != 0) {
                        $response .= 'https://vk.com/wall-'.$ownerId.'_'.$post.';';
                }
                sleep(0.15);
            }
            $user['like'] = $response;
            $response = '';

            ++$i;
            //sleep(1);
        }*/

        echo 'Началась запись в базу данных.'.' // '.date('Y-m-d H:i:s').PHP_EOL;
        foreach ($finalResult as $result) {
            echo 'Запись '.$i.'/'.count($finalResult).' // '.date('Y-m-d H:i:s').PHP_EOL;
            $girl = new Girl();
            $girl->url = 'https://vk.com/id'.$result['id'];
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
            $girl->save();
            ++$i;
        }
        echo 'Запись успешно завершена.'.' // '.date('Y-m-d H:i:s').PHP_EOL;

        //dd($yra);
        //file_put_contents('babs.txt', $findUserByCity);


        //file_put_contents('babs.txt',$babsList);

        $profilesId = [];


        //file_put_contents('babs.txt',$profilesId);


        //dd($profilesId);
    }


    public function getBabs(array $getInfoUser, $ownerId, $groupNameForList)
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


