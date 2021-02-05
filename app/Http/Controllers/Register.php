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
        //Valida as entradas do request
        $this->validate($request, [
            'email' => 'required|min:8|unique:users',
            'name' => 'required|min:2',
            'password' => 'required|min:6|max:12' 
        ]);

        //Criptografamos a senha
        $request['password'] = hash('sha256', $request->password);

        //Cria um novo usuário
        $userNew = User::create($request->all());

        return response()->json([
            'message' => 'User successfully created',
            'user new' => $userNew
        ]);
    }

    public function profile($id){
        $profile = User::find($id);

        if(!$profile){
            return response()->json([
                'message' => 'User not found'
            ], 404); 
        }

        return response()->json([
            'User'.$id => $profile
        ], 200);
    }

    //
}
