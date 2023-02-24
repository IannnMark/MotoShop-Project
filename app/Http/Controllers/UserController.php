<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Auth;
use Redirect;
use App\Events\SendMail;
use Event;
use Mail;

class UserController extends Controller
{
    public function __construct(){
        $this->total = 0;
    }

    public function getSignup(){
        return view('user.signup');
    }

     public function postSignup(Request $request){

        $this->validate($request, [
            'email' => 'email| required| unique:users',
            'password' => 'required| min:4',
        ]);
         $user = new User([
            'name' => $request->input('fname').' '.$request->lname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role').''.$request->role='customer'
        ]);
        $user->save();

         $customer = new Customer();
         $customer->user_id = $user->id;
         $customer->fname = $request->fname;
         $customer->lname = $request->lname;
         $customer->address = $request->address;
         $customer->town = $request->town;
         $customer->city = $request->city;
         $customer->phone = $request->phone;

         if($file = $request->hasFile('cust_img')) {
            $file = $request->file('cust_img') ;
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path().'/img_path' ;
            $input['cust_img'] = 'img_path/'.$fileName;
            $file->move($destinationPath,$fileName);
    
            $customer->cust_img = $fileName;
    
             }

         $customer->save();

         Event::dispatch(new SendMail($user));
         Auth::login($user);
         return redirect()->route('user.profile')->with("Welcome to Acme Pet Clinic!");
    }

    public function getSignin(){
        return view('user.signin');
    }

    public function getProfile(){

        $customers = Customer::where('user_id',Auth::id())->get();

        // $pet = Pet::has('customer', Auth::id())->get();

        return view('user.profile', compact('customers'));
    }

     public function getLogout(){
        Auth::logout();
        return redirect()->guest('/');
    }
}
