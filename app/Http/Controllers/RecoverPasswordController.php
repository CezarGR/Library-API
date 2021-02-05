<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class RecoverPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function recover(Request $request)
    {
        /**
         * email
         * password new
         * passwor repeat
        */

        $this->validate($request, [
            'email'=> 'required|min:1',
        ]);

        
        $userRecover = User::where('email', $request->email)->first();

        if($userRecover){
            if($request->password === $request->passwordCheck){
                $userRecover->password = $request['password'] = hash('sha256', $request->password);
                $userRecover->save();
                return response()->json([
                    'message' => 'Password changed successfully',
                    'User' => $userRecover
                ]);
            }else{
                return response()->json([
                    'message' => 'Incompatible password',
                ], 404);
            }   
        }
        else{
            return response()->json([
                'message' => 'Invalid email',
            ], 404); 
        }

            

    }
}
