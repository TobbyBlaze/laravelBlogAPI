<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;
use Auth;
use DB;
//use App\Http\Controllers\Auth;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth::user()->id);

        $users = User::all();

        $followers = $user->followers;
        $followings = $user->followings;

        // $ufollowers = $users->followers;
        // $ufollowings = $users->followings;

        //$posts = Post::orderBy('posts.updated_at', 'desc')->paginate(20);
        $posts = Post::orderBy('posts.updated_at', 'desc')->join('followers', 'followers.leader_id', '=', 'posts.user_id')->where('followers.follower_id', $user->id)/*->where('followers.follower_id', 'posts.user_id')*/->paginate(20);
        //$posts = DB::select('SELECT * FROM posts ORDER BY DESC');
        //return view('posts.index')->with('posts', $posts);
        return view('posts.index', compact('user', 'users', 'followers' , 'followings', 'posts'), ['user' => $user])->with('posts', $posts)->with('user', $user);
        //return response()->json($posts);
        //return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['body' => 'required']);
        //return 123; 'image' => , 'file' => 'nullable|max:6000'

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/images', $filenameToStore);
            //}elseif($extension == "mp4" || $extension == "flv" || $extension == "avi" || $extension == "3gp" || $extension == "evo"){
            //    $path = $request->file('file')->storeAs('public/files/videos', $filenameToStore);
            //}elseif($extension == "aac" || $extension == "mp3" || $extension == "ogg" || $extension == "wma"){
            //    $path = $request->file('file')->storeAs('public/files/audios', $filenameToStore);
            }else{
                $path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            }

            //create post

            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            //$post->document = $filenameToStore;

            //$extension = $request->file('file')->getClientOriginalExtension();
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $post->image = $filenameToStore;
            //}elseif($extension == "mp4" || $extension == "flv" || $extension == "avi" || $extension == "3gp" || $extension == "evo"){
            //    $post->video = $filenameToStore;
            //}elseif($extension == "aac" || $extension == "mp3" || $extension == "ogg" || $extension == "wma"){
            //    $post->audio = $filenameToStore;
            }else{
                $post->file = $filenameToStore;
            }
            
            $post->save();

            return redirect('/')->with('success', 'Post created successfully');
            
            
        }else{
            $filenameToStore = 'NoFile';

            //create post

            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            //$post->document = $filenameToStore;
            
            $post->save();

            return redirect('/')->with('success', 'Post created successfully');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        $user = User::find($userId);
        $followers = $user->followers;
        $followings = $user->followings;

        return view('posts.show', compact('user', 'followers' , 'followings', 'posts'))->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/')->with('error', 'Unauthorised page');
        }

        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, ['body' => 'required']);
        //return 123;

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/images', $filenameToStore);
            //}elseif($extension == "mp4" || $extension == "flv" || $extension == "avi" || $extension == "3gp" || $extension == "evo"){
            //    $path = $request->file('file')->storeAs('public/files/videos', $filenameToStore);
            //}elseif($extension == "aac" || $extension == "mp3" || $extension == "ogg" || $extension == "wma"){
            //    $path = $request->file('file')->storeAs('public/files/audios', $filenameToStore);
            }else{
                $path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            }

            //create post

            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            //$post->document = $filenameToStore;

            //$extension = $request->file('file')->getClientOriginalExtension();
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $post->image = $filenameToStore;
            //}elseif($extension == "mp4" || $extension == "flv" || $extension == "avi" || $extension == "3gp" || $extension == "evo"){
            //    $post->video = $filenameToStore;
            //}elseif($extension == "aac" || $extension == "mp3" || $extension == "ogg" || $extension == "wma"){
            //    $post->audio = $filenameToStore;
            }else{
                $post->file = $filenameToStore;
            }
            
            $post->save();

            return redirect('/')->with('success', 'Post created successfully');
            
            
        }else{
            $filenameToStore = 'NoFile';

            //create post

            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            //$post->document = $filenameToStore;
            
            $post->save();

            return redirect('/')->with('success', 'Post updated successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/')->with('error', 'Unauthorised page');
        }

        /*
        if($post->file != 'noimage.jpg'){
            Storage::delete('public/files/'.$post->file);
        }

        if($post->file){
            Storage::delete('public/files/documents/'.$post->file);
        }

        if($post->image){
            Storage::delete('public/files/images/'.$post->image);
        }
        */

        Storage::delete('public/files/documents/'.$post->file);
        Storage::delete('public/files/images/'.$post->image);
        $post->delete();

        return redirect('/')->with('success', 'Post deleted successfully');
    }
}
