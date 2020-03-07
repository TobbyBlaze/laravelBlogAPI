<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;

class FindController extends Controller
{
    public function all(){
        $q = Input::get ( 'q' );
        $posts = Post::where ( 'title', 'LIKE', '%' . $q . '%' )->orWhere ( 'body', 'LIKE', '%' . $q . '%' )->paginate(20);
        $user = User::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'email', 'LIKE', '%' . $q . '%' )->paginate(20);

        $user1 = User::find(auth::user()->id);
        $users = User::where('users.status', '!=', auth()->user()->status)->orWhere('users.department', '=', auth()->user()->department)->orWhere('users.school', '=', auth()->user()->school)->orWhere('users.college', '=', auth()->user()->college)->orderBy('users.updated_at', 'desc')->paginate(10);

        $followers = $user1->followers;
        $followings = $user1->followings;

        $find_data = [
            'q' => '$q',
            'posts' => '$posts',
            'user' => '$user',
            'user1' => '$user1',
            'users' => '$users',
            'followers' => '$followers',
            'followings' => '$followings',
        ];

        if($q != null){
            if (count($posts)>0||count($user)>0){

                //return response()->json(USER::all());
                // return view ( 'pages.found-all', compact('user', 'users', 'followers' , 'followings', 'posts') )->withDetails (  $user, $users, $posts )->withQuery ( $q );
                return response()->json($find_data);
            }
        }else{
            return redirect()->back();
        }
    }
}
