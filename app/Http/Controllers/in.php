<?php


namespace App\Http\Controllers;


use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class in extends Controller
{
    public $codik;

    public function index()
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
        return view('getkey', compact('browser_url'));

        //dd($browser_url);

    }

   public function second()
   {
       $codik = $_GET['code'];
       return view('second', compact('codik'));
   }

}
