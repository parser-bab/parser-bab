<?php

namespace App\Http\Controllers;

use App\Application;
use App\NeedUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::all();
        return view('applicationIndex', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createApplication');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();

        $oauth = new VKOAuth();
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);
        $state = 'secret_state_code';
        $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $data['client_id'], $data['redirect_uri'], $display, $scope, $state);

        $data['browser_url'] = $browser_url;
        $store = (new Application())->create($data);
        return redirect()->route('PersonalCabinet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Application::find($id);
        $data->delete();
        return redirect()->route('PersonalCabinet');
    }

    public function writeId($id)
    {
        $application = Application::find($id);
        $data['client_id'] = $application->client_id;
        $item = (new NeedUpdate())->create($data);
        return redirect()->to($application->browser_url);
    }

    public function getToken(Request $request)
    {
        $need = NeedUpdate::first();
        $client_id = $need->client_id;
        $application = Application::where('client_id', $client_id)->first();

        $code = $request->input('code');
        $oauth = new VKOAuth();
        $response = $oauth->getAccessToken($application->client_id, $application->client_secret, $application->redirect_uri, $code);

        $application->access_token = $response['access_token'];
        $application->vk_token_expires = Carbon::now()->addDay(1)->addHour(2);
        $application->save();


        $need->delete();
        $user = auth()->user()->vk_token = $response['access_token'];
        $user->save();

        return redirect()->route('application.index');
    }
}
