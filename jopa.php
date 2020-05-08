<?php


namespace App\Console\Commands;

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
    protected $signature = 'jopa:add';

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


    public $vk;


    public function __construct()
    {

        parent::__construct();
        $this->vk = new VKApiClient();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var VKOAuth @oauth
         */
        $oauth = new VKOAuth();
        $client_id = 7436120;

        $redirect_uri = 'http://127.0.0.1/second';
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
        $state = 'secret_state_code';

        $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);

        //dd($browser_url);

        $oauth = new VKOAuth();
        $client_id = 7436120;
        $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
        $redirect_uri = 'http://127.0.0.1/second';

        /**
         * @var ApiController $codemu
         */


        $code = '517e3fec1c5143a003';
        //dd($code);

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        $access_token = $response['access_token'];
        //dd($access_token);

        $vk = new VKApiClient();

        $ownerId = 40836944;


        $postsListAll = $vk->wall()->get($access_token, array(
            'owner_id' => '-'.$ownerId,
            'offset' => 0,
            'count' => 1

        ));
        $postsList = $postsListAll['items'];
        $postsId = [];
        foreach ($postsList as $post) {
            $postsId [] = $post['id'];
        }
        //dd($postsId);

        $profilesId = [];
        $profilesLikeList = [];
        $i = 1;
        foreach ($postsId as $postId) {
            //$offset = 0;

            for ($offset = 0; $offset < 10000; $offset = $offset + 1000) {
                $profilesLikeListAll = $vk->likes()->getList($access_token, array(
                    'type' => 'post',
                    'owner_id' => '-' . $ownerId,
                    'item_id' => $postId,
                    'filter' => 'likes',
                    'extended' => '1',
                    'count' => '1000',
                    'offset' => $offset
                ));
                //echo count($profilesLikeListAll['items']).'<br>';
                //dd($profilesLikeListAll);
                if (count($profilesLikeListAll['items']) != 0) {
                    $profilesLikeList [] = $profilesLikeListAll['items'];
                } else {
                    break;
                }
            }

            echo 'Пост '.$i.'/'.count($postsId).PHP_EOL;
            ++$i;


        }
        foreach ($profilesLikeList as $profileList) {
            foreach ($profileList as $profile) {
                $profilesId [] = 'http://vk.com/id'.$profile['id'].PHP_EOL;
            }


        }
        file_put_contents('babs.txt',$profilesId);
        echo 'OK!';
        echo count($profilesId);
        //dd($profilesId);
    }
}


/**
 * $oauth = new VKOAuth();
 * $client_id = 7436120;
 * $redirect_uri = 'https://oauth.vk.com/authorize';
 * $display = VKOAuthDisplay::PAGE;
 * $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
 * $state = 'secret_state_code';
 *
 * $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
 *
 *
 * $oauth = new VKOAuth();
 * $client_id = 7436120;
 * $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
 * $redirect_uri = 'https://oauth.vk.com/authorize';
 * $code = 'CODE';
 *
 * $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
 *
 * $access_token = $response['access_token'];
 */


/**
 * session_start();
 * $client_id = '7436120';
 * $redirect_uri = 'http://localhost';
 * $display = 'page';
 * $scope = 'friends,groups';
 * $response_type = 'code';
 * $auth_uri = "https://oauth.vk.com/authorize?client_id={$client_id}&display={$display}&redirect_uri={$redirect_uri}&scope={$scope}&response_type={$response_type}&v=5.52";
 *
 *
 *
 * $code = '04d831b39be80b217c';
 *
 *
 *
 * $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
 * $acces_uri = "https://oauth.vk.com/access_token";
 * $fields = array(
 * 'client_id' => $client_id,
 * 'client_secret' => $client_secret,
 * 'redirect_uri' => $redirect_uri,
 * 'code' => $code
 * );
 * $acces_uri .= "?client_id={$fields['client_id']}&";
 * $acces_uri .= "client_secret={$fields['client_secret']}&";
 * $acces_uri .= "redirect_uri={$fields['redirect_uri']}&";
 * $acces_uri .= "code={$fields['code']}";
 *
 *
 *
 * $res = file_get_contents($acces_uri);
 * $response_string = json_decode($res, true);
 * $_SESSION['token'] = $response_string['access_token'];
 * //dd($res);
 *
 *
 *
 * $name = 'Маша';
 * $url = $url = "https://api.vk.com/method/users.search?city_id=1&q={$name}&count=1000&access_token={$_SESSION['token']}";
 * $res = file_get_contents($url);
 * $users_data = json_decode($res,true);
 *
 * $users_count = array_shift($users_data);
 * //$users_list = $users_data['response'];
 * dd($users_count);
 */
