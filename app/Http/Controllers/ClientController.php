<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $allProducts = Product::all();
        $newArrival = Product::where('type', 'new-arrivals')->get();
        $hotSale = Product::where('type', 'sale')->get();
        /*
        compact('allProducts', 'newArrival', 'hotSale') is a PHP function that creates an array
        where each variable name passed to compact() becomes a key in the array,
        and its corresponding variable value is used as the value.

        The view() function accepts a view name ('index') as its first argument and
        an optional second argument of an array or compacted variables. In this case,
        it passes three variables ($allProducts, $newArrival, and $hotSale) to the 'index' view.
        These variables can then be accessed within the 'index.blade.php'
         */
        return view('index', compact('allProducts', 'newArrival', 'hotSale'));
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
    public function singleProduct($id)
    {
        $product = Product::find($id); #find the exact product
        return view('singleProduct', compact('product'));
    }
    public function register()
    {
        return view('register');
    }
    public function login()
    {
        return view('login');
    }
    public function logout(Request $request)
    {
        #Log out the user
        Auth::logout();

        #Invalidate the session
        /*
        This step invalidates the current session data associated with the user.
        It ensures that any existing session data is no longer considered valid after logout.

        Invalidating the session ensures that any stored session data is no longer usable after logout.
         */
        $request->session()->invalidate();

        #Regenerate the session token
        /*
         Regenerating the session token is crucial for preventing session fixation attacks.
        This process generates a new CSRF token and updates the session ID, 
        making it difficult for attackers to hijack a session.

        Regenerating the session token helps protect against session fixation attacks,
        here an attacker tries to reuse a valid session ID to impersonate a user.
         */
        $request->session()->regenerateToken();

        return redirect('/login');
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
