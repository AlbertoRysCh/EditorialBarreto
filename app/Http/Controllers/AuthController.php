<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helpers\LogSystem;

class AuthController extends Controller
{
        public function index()
        {
            return view('auth.login');
        }  
        public function register()
        {
            return view('register');
        }
        
        public function postLogin(Request $request)
        {
          $this->validateLogin($request);
          $credentials = array_merge( request(['username']) ,['password'=> $request->password ,'estado'=> 1 ]);
            if (!Auth::attempt($credentials)) {
              return back()->withErrors(['username' => trans('auth.failed')])
              ->withInput(request(['username']));
            }
              // Authentication passed...
              LogSystem::addLog('Inicio de sesión',1);
              return redirect()->intended('/inicio');
        }

        protected function validateLogin(Request $request){
          $this->validate($request,[
              'username' => 'required|string',
              'password' => 'required|string'
          ]);
  
        }

        public function postRegister(Request $request)
        {  
            request()->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            ]);
            
            $data = $request->all();
            $this->create($data);
          
            return Redirect::to("dashboard")->withSuccess('Great! You have Successfully loggedin');
        }
        
        public function create(array $data)
        {
          return User::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
          ]);
        }
        
        public function logout() {
            LogSystem::addLog('Cierre de sesión',1);
            Session::flush();
            Auth::logout();
            return Redirect('/');
        }
}

