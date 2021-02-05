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
        $emailValido = Book::where('author', $request->author)->first();
        

        if(!$emailValido){
            $userNew = Book::create($request->all());
            return response()->json([
                'message' => 'Book successfully created',
                'user new' => $userNew
            ]);
        }
        else{
            return response()->json([
                'message' => 'Existing author',
            ], 401);  
        }

        
    }

    //
}
