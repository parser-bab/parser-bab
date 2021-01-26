<?php


namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;
use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class PersonalCabinetController extends Controller
{
    public $codik;

    public function index(Request $request)
    {
//        dd(auth()->user());
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

        $code = $request->input('code');
        return view('PersonalCabinet.index', compact('browser_url','code'));

        //dd($browser_url);
    }

   public function second(Request $request)
   {
       $code = $request->input('code');
       $user = auth()->user();
       $user->vk_token = $code;
       $user->save();
       return redirect()->route('PersonalCabinet');
//       return view('second', compact('codik'));
   }

}
