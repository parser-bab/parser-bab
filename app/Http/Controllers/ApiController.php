<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VK\Client\VKApiClient;
use VK\OAuth\VKOAuth;

class ApiController extends Controller
{
    public $lala2;
    public function index(Request $request)
    {
       $this->lala2 = $_GET['code'];
       //dd($this->lala2);

        $oauth = new VKOAuth();
        $client_id = 7436120;
        $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
        $redirect_uri = 'http://127.0.0.1/api';

        /**
         * @var ApiController $codemu
         */


        $code = $this->lala2;
        //dd($code);

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        $access_token = $response['access_token'];
        //dd($access_token);

        $vk = new VKApiClient();
        $response = $vk->users()->get($access_token, array(
            'user_ids' => array(1, 210700286),
            'fields' => array('city', 'photo'),
        ));
        $response2 = $vk->likes()->getList($access_token, array(
            'type' => 'post',
            'owner_id' => '-178043004',
            'item_id' => '337',
            'filter' => 'likes',
            'extended' => '1',
            'count' => '30',
        ));
        dd($response);





    }

}
