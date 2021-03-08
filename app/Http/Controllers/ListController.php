<?php

namespace App\Http\Controllers;

use App\Chicken;
use App\Girl;
use App\MusicGirl;
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

    public function indexNorm()
    {
        $lists = $this->girlModel->where('write', 1)->with('posts', 'groups')->withCount('groups')
            ->paginate(30);
        return view('list', compact('lists'));
    }

    public function index()
    {
        $lists = $this->girlModel->with('posts', 'groups')->withCount('groups')
            ->orderByDesc('groups_count')
            ->orderBy('first_name')
            ->paginate(30);
        return view('list', compact('lists'));
    }

    public function indexByDate()
    {
        $lists = $this->girlModel->where('write', 1)
            ->orderByDesc('last_seen')
            ->with('posts', 'groups')
            ->withCount('groups')
            ->paginate(30);
        return view('list', compact('lists'));
    }

    public function indexMusicAll()
    {
        $lists = Chicken::with('notes')->paginate(30);
        return view('listGirlMusic', compact('lists'));
    }


    public function indexNormMusic()
    {
        $lists = Chicken::where('write', 1)->with('notes')->withCount('notes')
            ->paginate(30);
        return view('listGirlMusic', compact('lists'));
    }

    public function indexByCount()
    {
        $lists = Chicken::where('write', 1)
            ->with('notes')
            ->withCount('notes')
            ->orderByDesc('notes_count')
            ->orderBy('first_name')
            ->paginate(30);
        return view('listGirlMusic', compact('lists'));
    }


    public function indexByDateMusic()
    {
        $lists = Chicken::where('write', 1)
            ->orderByDesc('last_seen')
            ->with('notes')
            ->withCount('notes')
            ->paginate(30);
        return view('listGirlMusic', compact('lists'));
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

    public function destroyApi(Request $request)
    {
        $girl = Girl::findOrFail($request->input('id'));
        $groups = $girl->groups()->get();
        $posts = $girl->posts()->get();
        $girl->groups()->detach($groups);
        $girl->posts()->detach($posts);
        $girl->delete();
    }

    public function destroyApiMusic(Request $request)
    {
        $girl = MusicGirl::findOrFail($request->input('id'));
        $musics = $girl->musics()->get();
        $girl->musics()->detach($musics);
        $girl->delete();
    }

    function removedata(Request $request)
    {
        $girl = Girl::findOrFail($request->input('id'));
        if($girl->delete()) {
            echo 'Date deleted';
        }
    }
}
