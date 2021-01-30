<?php


namespace App\Http\Controllers;



use App\Events\TaskUpdated;
use App\Girl;
use App\Group;
use App\Jobs\StartTask;
use App\Task;
use App\User;
use Carbon\Carbon;
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
        dd(Girl::find(66)->posts()->get());
        $tasks = Task::all();
//        $job = new StartTask();
//        $this->dispatch($job);
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
        //dd($browser_url);
        $code = $request->input('code');
        //$task = Task::find(1);
        return view('PersonalCabinet.index',compact('tasks'));

        //dd($browser_url);
    }

   public function getToken(Request $request)
   {
//       dd($request->input());
       $code = $request->input('code');

       $client_id = 7436120;
       $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
       $redirect_uri = 'http://127.0.0.1/second';
       $code = $request->input('code');

       $oauth = new VKOAuth();
       $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);

       $user = auth()->user();
       $user->vk_token = $response['access_token'];
       $user->vk_token_expires = Carbon::now()->addDay(1)->addHour(2);
       $user->save();
       return redirect()->route('PersonalCabinet');
//       return view('second', compact('codik'));
   }

   public function createTask()
   {
//       $girls = Girl::query()->find([1,2]);
//       $group = Group::query()->find(1);
//       $group->girls()->attach($girls);
//       dd($group->girls()->get());
       return view('PersonalCabinet.createTask');
   }

   public function storeTask (Request $request)
   {
       $data = $request->input();
       $data['vk_token'] = auth()->user()->vk_token;
       $task = (new Task())->create($data);
       $job = (new StartTask($task));
       $this->dispatch($job);

       return redirect()->route('PersonalCabinet');
   }

}
