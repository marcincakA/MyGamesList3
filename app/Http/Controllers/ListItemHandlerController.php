<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListItemHandlerController extends Controller
{
    public function showMyList($userId){
        if (auth()->user()?->user_id == $userId || auth()->user()?->isAdmin) {
            return view('myList');
        }
        return redirect('/');
    }
}
