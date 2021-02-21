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
        $string = 'https://vk.com/id34867268
https://vk.com/id36082051
https://vk.com/id37316939
https://vk.com/id39782679
https://vk.com/id52143837
https://vk.com/id53390960
https://vk.com/id58597521
https://vk.com/id60032900
https://vk.com/id63567085
https://vk.com/id65318823
https://vk.com/id68022858
https://vk.com/id68628087
https://vk.com/id71242853
https://vk.com/id72424029
https://vk.com/id73723924
https://vk.com/id74218197
https://vk.com/id83462908
https://vk.com/id83892543
https://vk.com/id84397017
https://vk.com/id84536058
https://vk.com/id89449237
https://vk.com/id89814699
https://vk.com/id92331672
https://vk.com/id92596312
https://vk.com/id92954451
https://vk.com/id96602078
https://vk.com/id98912032
https://vk.com/id99315869
https://vk.com/id100924418
https://vk.com/id101092914
https://vk.com/id105170455
https://vk.com/id110860644
https://vk.com/id112594628
https://vk.com/id116184213
https://vk.com/id116334972
https://vk.com/id117059840
https://vk.com/id118232035
https://vk.com/id118561103
https://vk.com/id121666715
https://vk.com/id122369201
https://vk.com/id124312459
https://vk.com/id126484387
https://vk.com/id127862304
https://vk.com/id131974052
https://vk.com/id132431593
https://vk.com/id134002674
https://vk.com/id134181549
https://vk.com/id134741031
https://vk.com/id134748158
https://vk.com/id136568269
https://vk.com/id136932932
https://vk.com/id137031155
https://vk.com/id138670783
https://vk.com/id138827413
https://vk.com/id138882374
https://vk.com/id148155898
https://vk.com/id149045968
https://vk.com/id150326030
https://vk.com/id150408016
https://vk.com/id150874457
https://vk.com/id150897781
https://vk.com/id152059429
https://vk.com/id153103863
https://vk.com/id156515938
https://vk.com/id157276393
https://vk.com/id158256880
https://vk.com/id166689006
https://vk.com/id166797258
https://vk.com/id169522462
https://vk.com/id173836878
https://vk.com/id174988255
https://vk.com/id175071928
https://vk.com/id175092894
https://vk.com/id176764708
https://vk.com/id179418978
https://vk.com/id184843479
https://vk.com/id187826433
https://vk.com/id188290165
https://vk.com/id191134699
https://vk.com/id191362539
https://vk.com/id192862589
https://vk.com/id193680122
https://vk.com/id194496497
https://vk.com/id195502956
https://vk.com/id198632228
https://vk.com/id203172031
https://vk.com/id205258142
https://vk.com/id206688710
https://vk.com/id210447451
https://vk.com/id210649730
https://vk.com/id211101133
https://vk.com/id215314380
https://vk.com/id215905180
https://vk.com/id226475546
https://vk.com/id229451345
https://vk.com/id231237592
https://vk.com/id235726347
https://vk.com/id250795909
https://vk.com/id251157321
https://vk.com/id268455597
https://vk.com/id270442279
https://vk.com/id292527520
https://vk.com/id292746586
https://vk.com/id303720856
https://vk.com/id337399204
https://vk.com/id359813204
https://vk.com/id369891934
https://vk.com/id391745263
https://vk.com/id395968017
https://vk.com/id405214891
https://vk.com/id422176499
https://vk.com/id467411789
https://vk.com/id473266447
https://vk.com/id488935407
https://vk.com/id519967381
https://vk.com/id627776580';
        $norm = str_replace('https://vk.com/id', '', explode("\n",$string));
        $girls = Girl::where(function ($query) use ($norm) {
            foreach ($norm as $item) {
                $query->orWhere('url', 'LIKE', '%'.$item.'%');
            }
        })->get();
        foreach ($girls as $girl) {
            $girl->age = 22;
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
