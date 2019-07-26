<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('pages.index');
    }

    public function about(){
        return view('pages.about');
    }

    public function find(){
        $user = User::all();
        $followers = $user->followers;
        $followings = $user->followings;


        return view('pages.find', compact('user', 'followers' , 'followings', 'posts'));
    }

    public function notification(){
        return view('pages.notification');
    }

    public function profile(){
        return view('pages.profile');
    }
}
