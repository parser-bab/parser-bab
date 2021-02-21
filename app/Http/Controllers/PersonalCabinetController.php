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
        $removeChar = ["https://", "http://", "/", 'vk.com', 'public'];
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
//        $girls = Girl::all();
        $string = 'https://vk.com/id7985377
https://vk.com/id48109824
https://vk.com/id62509781
https://vk.com/id62747936
https://vk.com/id66477803
https://vk.com/id67182675
https://vk.com/id70455724
https://vk.com/id75886353
https://vk.com/id80307843
https://vk.com/id84210104
https://vk.com/id100244986
https://vk.com/id105246832
https://vk.com/id112908810
https://vk.com/id116657555
https://vk.com/id117234909
https://vk.com/id119016270
https://vk.com/id123124777
https://vk.com/id125877255
https://vk.com/id133586145
https://vk.com/id134867252
https://vk.com/id134901326
https://vk.com/id136621376
https://vk.com/id137185168
https://vk.com/id139165193
https://vk.com/id140929664
https://vk.com/id142487356
https://vk.com/id145346091
https://vk.com/id151817423
https://vk.com/id152345616
https://vk.com/id152480274
https://vk.com/id155793581
https://vk.com/id156387817
https://vk.com/id156724560
https://vk.com/id158363036
https://vk.com/id159442555
https://vk.com/id160799910
https://vk.com/id162195504
https://vk.com/id164707218
https://vk.com/id165468814
https://vk.com/id167865963
https://vk.com/id172422890
https://vk.com/id182618964
https://vk.com/id185968382
https://vk.com/id195095970
https://vk.com/id199432243
https://vk.com/id202001688
https://vk.com/id202243743
https://vk.com/id209791449
https://vk.com/id212633627
https://vk.com/id212739024
https://vk.com/id224205443
https://vk.com/id228716700
https://vk.com/id228722040
https://vk.com/id235258367
https://vk.com/id235536370
https://vk.com/id238547573
https://vk.com/id240337305
https://vk.com/id246778980
https://vk.com/id247530485
https://vk.com/id248764680
https://vk.com/id252653702
https://vk.com/id256291041
https://vk.com/id257375727
https://vk.com/id258386492
https://vk.com/id260392137
https://vk.com/id261281238
https://vk.com/id265536508
https://vk.com/id269476422
https://vk.com/id269623598
https://vk.com/id279203264
https://vk.com/id280501984
https://vk.com/id284983342
https://vk.com/id295825601
https://vk.com/id303611491
https://vk.com/id307227957
https://vk.com/id309587657
https://vk.com/id311549936
https://vk.com/id314336029
https://vk.com/id318685467
https://vk.com/id320166183
https://vk.com/id324029068
https://vk.com/id340327394
https://vk.com/id353232061
https://vk.com/id362161878
https://vk.com/id409652872
https://vk.com/id414407892
https://vk.com/id443313727
https://vk.com/id449228909
https://vk.com/id462113546
https://vk.com/id471911425
https://vk.com/id492110185
https://vk.com/id496502967
https://vk.com/id503095632
https://vk.com/id531342087
https://vk.com/id554971760
https://vk.com/id573417813
https://vk.com/id594086022
https://vk.com/id598689379
https://vk.com/id598914228
https://vk.com/id628504494
https://vk.com/id607080138';
        $norm = str_replace('https://vk.com/id', '', explode("\n",$string));
        $girls = Girl::where(function ($query) use ($norm) {
            foreach ($norm as $item) {
                $query->orWhere('url', 'LIKE', '%'.$item.'%');
            }
        })->get();
        foreach ($girls as $girl) {
            $girl->age = 20;
            $girl->save();
        }
        dd($girls);
//        $girls = Girl::all();
//        foreach ($girls as $girl) {
//            if($girl->last_seen !== '0') {
//                $girl->last_seen = Carbon::parse($girl->last_seen)->timestamp;
//                $girl->save();
//            }
//        }
//        $girls = Girl::all();
//        foreach ($girls as $girl) {
//            $count = explode('.', $girl->bdate);
//            if (count($count) == 3) {
//                $first = \Illuminate\Support\Carbon::createFromFormat('d.m.Y', '01.01.1994');
//                $second = Carbon::createFromFormat('d.m.Y', '01.01.2003');
//                $carbon = Carbon::createFromFormat('d.m.Y', $girl->bdate)->between($first, $second);
//                if($carbon === false) {
//                    $groups = $girl->groups()->get();
//                    $posts = $girl->posts()->get();
//                    $girl->groups()->detach($groups);
//                    $girl->posts()->detach($posts);
//                    $girl->delete();
//                }
//            }
//        }
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
