<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commons['page_title'] = 'User';
        $commons['content_title'] = 'List of All User';
        $commons['main_menu'] = 'user';
        $commons['current_menu'] = 'user_index';


        $users = User::where('status', 1)    
            ->latest()
            ->paginate(20);
     

        //dd($users);
        return view('backend.pages.user.index', compact('commons', 'users'));
    }





}
