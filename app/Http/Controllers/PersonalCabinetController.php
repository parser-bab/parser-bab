<?php


namespace App\Http\Controllers;


use App\Application;
use App\Events\TaskUpdated;
use App\Girl;
use App\Group;
use App\Jobs\StartTask;
use App\Post;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\DB;
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
        $tasks = Task::all();
//        $job = new StartTask();
//        $this->dispatch($job);
//        dd(auth()->user());
        /**
         * @var VKOAuth @oauth
         */
        $oauth = new VKOAuth();
        $client_id = 7457469;

        $redirect_uri = 'http://127.0.0.1/second';
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
        $state = 'secret_state_code';

        $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);

        //https://oauth.vk.com/authorize?client_id=7457469&redirect_uri=http%3A%2F%2F127.0.0.1%2Fsecond&display=page&scope=270336&state=secret_state_code&response_type=code&v=5.101
        // dd($browser_url);
        $code = $request->input('code');
        //$task = Task::find(1);
        return view('PersonalCabinet.index', compact('tasks'));

        //dd($browser_url);
    }

    public function getToken(Request $request)
    {
        //     dd($request->input());
        $code = $request->input('code');

        $client_id = 7436120;
        $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
        $redirect_uri = 'http://92.38.152.201/second';
        $code = $request->input('code');
//	dd($code);
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
        $applications = Application::all();
        return view('PersonalCabinet.createTask', compact('applications'));
    }

    public function storeTask(Request $request)
    {
        //dd($request->input());
        $data = $request->input();

        $group = $data['url_group'];
        $removeChar = ["https://", "http://", "/", 'vk.com'];
        $groupName = str_replace($removeChar, "", $group);

        $vk = new VKApiClient();
        $owner = $vk->groups()->getById(auth()->user()->vk_token, array(
            'group_ids' => $groupName
        ));

        $data['title'] = $owner[0]['name'];

        //$data['vk_token'] = auth()->user()->vk_token;
        $task = (new Task())->create($data);
        $job = (new StartTask($task));
        $this->dispatch($job);

        return redirect()->route('PersonalCabinet');
    }

    public function logs()
    {
        $data = DB::table('failed_jobs')->get();
        return view('PersonalCabinet.logs', compact('data'));
    }

    public function clearJob()
    {
        DB::table('jobs')->truncate();
        DB::table('failed_jobs')->truncate();
        return redirect()->route('PersonalCabinet');
    }

    public function checkTask(Request $request)
    {
        $group = $request->input('url');
        $removeChar = ["https://", "http://", "/", 'vk.com', 'public'];
        $groupName = str_replace($removeChar, "", $group);

        $vk = new VKApiClient();
        $owner = $vk->groups()->getById(auth()->user()->vk_token, array(
            'group_ids' => $groupName
        ));

        $name = $owner[0]['name'];
        $task = Task::where('title', $name)->get();
        return response()->json($task, 200);
    }

    public function fix()
    {
        $girls = Girl::all();
        foreach ($girls as $girl) {
            $count = explode('.', $girl->bdate);
            if (count($count) == 3) {
                $first = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', '01.01.1994');
                $second = Carbon::createFromFormat('d.m.Y', '01.01.2003');
                $carbon = Carbon::createFromFormat('d.m.Y', $girl->bdate)->between($first, $second);
                if($carbon === false) {
                    $groups = $girl->groups()->get();
                    $posts = $girl->posts()->get();
                    $girl->groups()->detach($groups);
                    $girl->posts()->detach($posts);
                    $girl->delete();
                }
            }
        }
//        for ($i = 1; $i <= 1767; ++$i) {
//            $item = DB::table('girl_post')
//                ->where('id', $i)
//                ->first();
//
//            $post = Post::find($item->post_id);
//            $girl = Girl::find($item->girl_id);
//
//            $id1 = explode('_', $post->url);
//            $id1 = $id1[0];
//            $id2 = explode('-', $id1);
//            $id = $id2[1];
//
////            $group = DB::table('groups')
////                ->where('url_group', '=', 'https://vk.com/public'.$id)
////                ->first();
//
//            $group = Group::where('url_group', '=', 'https://vk.com/club'.$id)->first();
//            $relation = DB::table('girl_group')
//                ->where('group_id', $group->id)
//                ->where('girl_id', $girl->id)
//                ->first();
////            dump($item, $post, $girl, $id, $group, $relation);
////            dd();
//            if (!$relation) {
//                $girl->groups()->attach($group);
//            }
//       }
//        $group = Group::find(1);
//        $girls = $group->girls()->get();
//        $group->girls()->detach($girls);
//        $group->delete();
//
//        $group = Group::find(35);
//        $girls = $group->girls()->get();
//        $group->girls()->detach($girls);
//        $group->delete();


//        $groups = Task::all();
//        $vk = new VKApiClient();
//        foreach ($groups as $group) {
//            $removeChar = ["https://", "http://", "/", 'vk.com'];
//            $groupName  = str_replace($removeChar, "", $group->url_group);
//            $owner = $vk->groups()->getById(auth()->user()->vk_token, array(
//                'group_ids' => $groupName
//            ));
//            $group->title = $owner[0]['name'];
//            $group->save();
//            usleep(340000);
//        }



//        $name = $owner[0]['name'];
//        $task = Task::where('title', $name)->get();


    }


}
