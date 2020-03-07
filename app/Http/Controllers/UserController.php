<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\newComment;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function viewProfile(User $user)

    public function notification(int $profileId){
        $user = User::find($profileId);

        if($user){
            $users = User::where('users.status', '!=', auth()->user()->status)->orderBy('users.created_at', 'desc')->paginate(10);

            $posts = Post::orderBy('updated_at', 'desc')->where('posts.user_id', $user->id)->paginate(20);
            $comments = Comment::orderBy('comments.updated_at', 'desc')
            ->paginate(20);
            $post = Post::find($user->id);

            $notification_data = [
                'user' => '$user',
                'users' => '$users',
                'posts' => '$posts',
                'comments' => '$comments',
                'post' => '$post',
            ];

            return response()->json($notification_data, 201);
        }else{
            return redirect()->back();
        }
    }

    public function notificationRead(int $profileId){
        $user = User::find($profileId);
       
        if($user){
            $users = User::where('users.status', '!=', auth()->user()->status)->orderBy('users.created_at', 'desc')->paginate(10);

            $posts = Post::orderBy('updated_at', 'desc')->where('posts.user_id', $user->id)->paginate(20);
            $comments = Comment::orderBy('comments.updated_at', 'desc')
            ->paginate(20);
            $post = Post::find($user->id);

            $notification_data = [
                'user' => '$user',
                'users' => '$users',
                'posts' => '$posts',
                'comments' => '$comments',
                'post' => '$post',
            ];

            auth()->user()->unReadNotifications->markAsRead();
            return redirect()->back();
        }else{
            return redirect()->back();
        }

    }

    public function viewProfile(int $profileId)
    {
        $user = User::find($profileId);
        if($user){
        $users = User::where('users.status', '!=', auth()->user()->status)->orderBy('users.created_at', 'desc')->paginate(10);

        $posts = Post::orderBy('updated_at', 'desc')->where('posts.user_id', $user->id)->paginate(20);
        
        $comments = Comment::orderBy('comments.updated_at', 'desc')
        ->paginate(20);

        $profile_data = [
            'user' => '$user',
            'users' => '$users',
            'posts' => '$posts',
            'comments' => '$comments',
        ];
        
        return response()->json($profile_data, 201);
        }else{
            return redirect()->back();
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function edit(User $user)
    {   
        //
    }

    public function find(){
        $user = User::all();
        
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {

        $user = Auth::user();

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/profile_pics', $filenameToStore);
            }else{

            }

            //update user

            $user = User::find($id);
            $user->name = $request->input('name');
            // $user->title = $request->input('title');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            // $user->status = $request->input('status');
            $user->bio = $request->input('bio');
            $user->email = $request->input('email');
            $user->phone_number_1 = $request->input('phone_number_1');
            $user->phone_number_2 = $request->input('phone_number_2');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->department = $request->input('department');
            $user->school = $request->input('school');
            $user->college = $request->input('college');

            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $user->image = $filenameToStore;
            }else{

            }
            
            $user->save();

            return redirect()->back()->with('success', 'successfully');
            
            
        }else{
            $filenameToStore = 'NoFile';

            //update user

            $user = User::find($id);
            $user->name = $request->input('name');
            // $user->title = $request->input('title');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            // $user->status = $request->input('status');
            $user->bio = $request->input('bio');
            $user->email = $request->input('email');
            $user->phone_number_1 = $request->input('phone_number_1');
            $user->phone_number_2 = $request->input('phone_number_2');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->department = $request->input('department');
            $user->school = $request->input('school');
            $user->college = $request->input('college');
            
            $user->save();

            return redirect()->back()->with('success', 'successfully');
        }

    }
}
