<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class Register extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function register(Request $request)
    {
        $emailValido = User::where('email', $request->email)->first();
        

        if(!$emailValido){
            $userNew = User::create($request->all());
            return response()->json([
                'message' => 'User successfully created',
                'user new' => $userNew
            ]);
        }
        else{
            return response()->json([
                'message' => 'Existing user',
            ], 401);  
        }

        
    }

    //
}
