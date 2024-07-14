<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function cart()
    {
        return view('cart');
    }
    public function checkout()
    {
        return view('checkout');
    }
    public function shop()
    {
        return view('shop');
    }
    public function singleProduct()
    {
        return view('singleProduct');
    }
    public function register()
    {
        return view('register');
    }
    public function login()
    {
        return view('login');
    }
    public function logout()
    {
        Auth::logout();
        return view('login');
    }

    public function registerUser(Request $request)
    {
        $newUser = new User();
        $newUser->name =  $request->input('name');
        $newUser->email =  $request->input('email');
        $newUser->password =  $request->input('password');
        #fetch the file name and store to database table
        $newUser->image =  $request->file('file')->getClientOriginalName();
        #upload the file to local folder(uploads/users)
        $request->file('file')->move('uploads/users/', $newUser->image);

        if ($newUser->save()) {
            #flash message, Flash messages are stored in the session but only available for the next request
            return redirect('login')->with('success', 'Congratulations! your account is created');
        }
    }

    public function loginUser(Request $request)
    {
        #Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        #extracting email and password from HTTP request and storing them in $credentials array
        $credentials = $request->only('email', 'password');

        # Authentication of login credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user['type'] == 'customer') {
                return redirect('/dashboard');
            }
        } else {
            #Authentication failed flash an error message
            return redirect('login')->with('error', 'Username/password is incorrect');
        }
    }
}
