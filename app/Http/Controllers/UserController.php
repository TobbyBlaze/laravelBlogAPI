<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    public function viewProfile(int $profileId)
    {
        $user = User::find($profileId);

        $followers = $user->followers;
        $followings = $user->followings;

        $posts = Post::orderBy('updated_at', 'desc')->where('posts.user_id', $user->id)->paginate(20);
        //$users = User::orderBy('updated_at', 'desc');
        return view('user.profile', compact('user', 'followers' , 'followings', 'posts'), ['user' => $user])->with('posts', $posts)->with('user', $user);
        //->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function followUser(int $profileId)
    {
        $user = User::find($profileId);
        if(!$user) {
            
            return redirect()->back()->with('error', 'User does not exist.'); 
        }

        $user->followers()->attach(auth()->user()->id);
        return redirect()->back()->with('success', 'Successfully followed the user.');
    }

    public function unFollowUser(int $profileId)
    {
        $user = User::find($profileId);
        if(! $user) {
            return redirect()->back()->with('error', 'User does not exist.'); 
        }
        $user->followers()->detach(auth()->user()->id);
        return redirect()->back()->with('success', 'Successfully unfollowed the user.');
    }

    public function show(int $userId)
    {
        $posts = Post::orderBy('updated_at', 'desc')->paginate(20);

        $user = User::find($userId);
        $followers = $user->followers;
        $followings = $user->followings;
        return view('user.show', compact('user', 'followers' , 'followings', 'posts'));
    }

    public function edit(User $user)
    {   
        $posts = Post::orderBy('updated_at', 'desc')->paginate(20);

        $user = Auth::user();

        $followers = $user->followers;
        $followings = $user->followings;
        return view('user.edit', compact('user', 'followers' , 'followings', 'posts'));
    }

    public function find(){
        $user = User::all();
        //$followers = $user->followers;
        //$followings = $user->followings;

        return view('pages.find');
        // return view('pages.find', compact('user', 'followers' , 'followings', 'posts'));
    }

    protected function update(array $data)
    {
        return User::create([
            'name' => $data['name'],
            //'status' => $data['status'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
