<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;
use App\Comment;
use App\Notifications\newComment;
use App\Notifications\newPost;
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
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['about']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = User::find(auth::user()->id);
        $users = User::where('users.status', '!=', auth()->user()->status)->orderBy('users.created_at', 'desc')->paginate(10);

        $posts = Post::orderBy('posts.updated_at', 'desc')->paginate(20);

        $comments = Comment::orderBy('comments.updated_at', 'desc')
        ->paginate(20);

        $data = [

            'user' => $user,
            'users' => $users,
            'posts'=>$posts,
            'comments' => $comments,

        ];

        return response()->json($data,200);
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
        $this->validate($request, ['body' => 'required']);

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/images', $filenameToStore);
            }elseif ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "pptx" || $extension == "tex" || $extension == "txt") {
                $path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            }

            //create post

            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
           
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $post->image = $filenameToStore;
            }elseif ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "pptx" || $extension == "tex" || $extension == "txt") {
                $post->file = $filenameToStore;
            }
            
            $post->save();

            return response()->json($post, 201);
            
        }else{
            $filenameToStore = 'NoFile';

            //create post

            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
           
            $post->save();

            return response()->json($post, 201);
        }

    }

    public function post(Request $request)
    {

        // $user = User::find($profileId);

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
            }elseif ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "pptx" || $extension == "tex" || $extension == "txt") {
                $path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            }

            //create post

            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            $post->post_user_id = $request->input('user_id');
           
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $post->image = $filenameToStore;
            }elseif ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "pptx" || $extension == "tex" || $extension == "txt") {
                $post->file = $filenameToStore;
            }
            
            $post->save();

            return response()->json($post, 201);
            
            
        }else{
            $filenameToStore = 'NoFile';

            //create post

            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            $post->post_user_id = $request->input('user_id');

            $post->save();

            User::find($post->user_id)->notify(new newPost);
            return response()->json($post, 201);
        }

    }

    public function store_comments(Request $request)
    {

        $this->validate($request, ['body' => 'required']);

            $comment = new Comment;
            $comment->body = $request->input('body');
            $comment->post_id = $request->input('post_id');
            $comment->post_user_id = $request->input('user_id');
            $comment->user_id = auth()->user()->id;
            
            $comment->save();

            User::find($comment->post_user_id)->notify(new newComment);

            return response()->json($comment, 201);

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

        $user = User::find($id);

        $users = User::where('users.status', '!=', auth()->user()->status)->orderBy('users.created_at', 'desc')->paginate(10);

        
        $posts = Post::all();

        Post::where('id', '=', $id)
        ->update([
            // Increment the view counter field
            'views' => 
            $post->views + 1        ,
            // Prevent the updated_at column from being refreshed every time there is a new view
            'updated_at' => \DB::raw('updated_at')   
        ]);

        $comments = Comment::orderBy('comments.updated_at', 'desc')
        ->paginate(20);

        $post_data = [
            'post' => '$post',
            'posts' => '$posts',
            'user' => '$user',
            'users' => '$users',
            'comments' => '$comments',
        ];

        return response()->json($post_data);

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

        $user = User::find($id);

        $users = User::where('users.status', '!=', auth()->user()->status)->orderBy('users.created_at', 'desc')->paginate(10);

        $posts = Post::orderBy('posts.updated_at', 'desc');
       
        if(auth()->user()->id !== $post->user_id){
            return response()->json($error, 401);
        }

        $edit_data = [
            'post' => '$post',
            'user' => 'user',
            'posts' => '$posts',
        ];

        return response()->json($edit_data, 201);
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

        $post = Post::find($id);

        $this->validate($request, ['body' => 'required']);

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/images', $filenameToStore);
            }elseif ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "zip" || $extension == "rar" || $extension == "pptx" || $extension == "tex" || $extension == "txt") {
                $path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            }

            //update post

            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $post->image = $filenameToStore;
            }elseif ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "zip" || $extension == "rar" || $extension == "pptx" || $extension == "tex" || $extension == "txt") {
                $post->file = $filenameToStore;
            }
            
            $post->save();

            return response()->json($post, 201);
            
            
        }else{
            $filenameToStore = 'NoFile';

            //update post

            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id = auth()->user()->id;

            $post->save();

            return response()->json($post, 201);
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

        Storage::delete('public/files/documents/'.$post->file);
        Storage::delete('public/files/images/'.$post->image);
        $post->delete();

        return response()->json($post, 201);
    }
}
