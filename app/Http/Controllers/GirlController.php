<?php

namespace App\Http\Controllers;

use App\Chicken;
use App\Girl;
use App\Jobs\CheckUpdate;
use App\Jobs\StartTask;
use App\MusicGirl;
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

    public function setPisalMusic(Request $request) {
        $girl = Chicken::find($request->input('id'));
        $girl->is_pisal = $request->input('is_pisal');
        $girl->save();
        return response()->json($girl,200);
    }

    public function setWriteMusic(Request $request) {
        $girl = Chicken::find($request->input('id'));
        $girl->write = $request->input('write');
        $girl->save();
        return response()->json($girl,200);
    }

    public function online()
    {
        $girl=Girl::take(50)->get();
        $girl_count = Girl::count();
//        $update_online = UpdateOnline::first();
        return view('girlOnline', compact('girl_count'));
    }

    public function updateOnline()
    {
        $token = auth()->user()->vk_token;
        $job = (new CheckUpdate($token));
        $this->dispatch($job);
        return redirect()->route('girl.online');
    }

}
