<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VK\Client\VKApiClient;
use VK\OAuth\VKOAuth;

class ApiEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request);
        $oauth = new VKOAuth();
        $client_id = 7436120;
        $client_secret = 'WpiQkAdSZvuLhHuPuHvi';
        $redirect_uri = 'http://127.0.0.1/second';


        $code = $request->get('codik');
        //dd($code);

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        $access_token = $response['access_token'];
        //dd($access_token);
        dd($access_token);

        $vk = new VKApiClient();
        $postsListAll = $vk->wall()->get($access_token, array(
            'owner_id' => '-' . $request->get('owner_id'),
            'offset' => 0,
            'count' => 1

        ));
        $postsList = $postsListAll['items'];
        $postsId = [];
        foreach ($postsList as $post) {
            $postsId [] = $post['id'];
        }
        //dd($postsId);
        $i = 1;
        $profilesId = [];
        $profilesLikeList = [];
        foreach ($postsId as $postId) {
            //$offset = 0;
            //
            for ($offset = 0; $offset < 10000; $offset = $offset + 1000) {
                $profilesLikeListAll = $vk->likes()->getList($access_token, array(
                    'type' => 'post',
                    'owner_id' => '-' . $request->get('owner_id'),
                    'item_id' => $postId,
                    'filter' => 'likes',
                    'extended' => '1',
                    'count' => '1000',
                    'offset' => $offset
                ));
                //echo count($profilesLikeListAll['items']).'<br>';
                //dd($profilesLikeListAll);
                if (count($profilesLikeListAll['items']) != 0) {
                    $profilesLikeList [] = $profilesLikeListAll['items'];
                } else {
                    break;
                }



            }
            echo 'Пост '.$i.'/'.count($postsId).PHP_EOL;
            flush();
            sleep(1);
            ++$i;

        }
        foreach ($profilesLikeList as $profileList) {
            foreach ($profileList as $profile) {
                $profilesId [] = $profile['id'];
            }


        }
        //echo $profilesId[0];
        echo 'OK!';


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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
