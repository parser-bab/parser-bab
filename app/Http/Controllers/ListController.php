<?php

namespace App\Http\Controllers;

use App\Girl;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    /**
     * @var Girl $girlModel
     */
    private $girlModel;
    public function __construct()
    {
        $this->girlModel = app()->make(Girl::class);
    }

    public function index()
    {
        $lists = $this->girlModel->with('posts', 'groups')->withCount('groups')->get()->sortByDesc('groups_count');
        return view('list', compact('lists'));
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
        $girl = Girl::findOrFail($id);
        $groups = $girl->groups()->get();
        $posts = $girl->posts()->get();
        $girl->groups()->detach($groups);
        $girl->posts()->detach($posts);
        $girl->delete();
        return redirect(route('list.index'));
    }

    function removedata(Request $request)
    {
        $girl = Girl::findOrFail($request->input('id'));
        if($girl->delete()) {
            echo 'Date deleted';
        }
    }
}
