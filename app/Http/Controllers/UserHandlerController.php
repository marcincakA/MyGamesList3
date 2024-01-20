<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\UserController;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserHandlerController extends Controller
{
    //todo RequestViemUpravit
    function register(Request $request) {
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:10', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password'=> ['required', 'min:8', 'max:20', 'confirmed']

        ]);


        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['password'] = strip_tags($incomingFields['password']);
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/');

    }

    function logout() {
        auth()->logout();
        return redirect('/');
    }

    function login(Request $request) {
        $incomingFields = $request->validate([
            'login_name' => ['required'],
            'login_password'=> ['required']
        ]);
        $incomingFields['login_name'] = strip_tags($incomingFields['login_name']);
        $incomingFields['login_password'] = strip_tags($incomingFields['login_password']);

        if (auth()->attempt([
            'name' => $incomingFields['login_name'],
            'password' => $incomingFields['login_password']
        ])) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/showLogin')->withErrors(['login_failed' => 'Invalid login credentials']);
    }

    function showEditScreen($user_id) {

        $user = User::find($user_id);
        if (auth()->user()->getKey() == $user->user_id || auth()->user()->isAdmin) {
            return view('editAccount', ['user' => $user]);
        }
        return redirect('/');
    }

    function updateUser($id, Request $request) {
        //@dd($id);

        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:10'],
            'email' => ['required', 'email'],
            'password'=> ['required', 'min:8', 'max:20'],
            'isAdmin' => []
        ]);
        $incomingFields['isAdmin'] = $request->has('isAdmin') ? 1 : 0;
        //@dd($incomingFields);
        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::find($id);

        //@dd($user->name);
        if (auth()->user()?->id == $user->id || auth()->user()?->isAdmin) {
            $user->update($incomingFields);
            //@dd($user->id);
            return redirect("/");

        }
    }
    function  deleteUser($id) {
        $user = User::find($id);
        if (auth()->user()?->isAdmin || $user->id == auth()->user()?->id){
            $user->delete();
        }
        return redirect('/');
    }
}
