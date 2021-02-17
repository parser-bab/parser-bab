<?php

namespace App\Http\Controllers;

use App\Girl;
use App\UpdateOnline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use VK\Client\VKApiClient;

class GirlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $girl = Girl::with('posts')->findOrFail($id);
        $referer = $request->headers->get('referer');
        return view('listGirl',compact('girl','referer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $girl = Girl::find($id);
        $girl->is_pisal = $request->input('is_pisal');
        $girl->save();
        return redirect()->to($request->input('referer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setPisal(Request $request) {
        $girl = Girl::find($request->input('id'));
        $girl->is_pisal = $request->input('is_pisal');
        $girl->save();
        return response()->json($girl,200);
    }

    public function setWrite(Request $request) {
        $girl = Girl::find($request->input('id'));
        $girl->write = $request->input('write');
        $girl->save();
        return response()->json($girl,200);
    }

    public function online()
    {
        $girl_count = Girl::count();
//        $update_online = UpdateOnline::first();
        return view('girlOnline', compact('girl_count'));
    }

    public function updateOnline()
    {
        $girls = Girl::all();
        $girls_count = Girl::all()->count();
        $count = ceil($girls_count/1000);


        $vk = new VKApiClient();
        $access_token = auth()->user()->vk_token;

        $offset = 0;
        for ($i = 0; $i <= $count; ++$i) {
            $girl_list = $girls->slice($offset, 1000);

            $profilesId = [];

            foreach($girl_list as $girl) {
                $removeChar = ["https://", "http://", "/", 'vk.com', 'id'];
                $girl_id = str_replace($removeChar, "", $girl->url);
                $profilesId[] = $girl_id;
            }


            $getInfoUser = $vk->users()->get($access_token, array(
                'user_ids' => $profilesId,
                'fields' => 'photo_200,city,sex,bdate,last_seen'
            ));
            foreach ($getInfoUser as $user) {
                if (isset($user['last_seen']['time'])) {
                    $girl_new = Girl::where('url', 'like', '%'.$user['id'])->first();
                    $girl_new->last_seen = Carbon::createFromTimestamp($user['last_seen']['time'])->addHours(2)->format('d.m.Y H:i');
                    $girl_new->save();
                }
            }
            $offset += 1000;
        }
        return redirect()->route('PersonalCabinet');

    }

}
