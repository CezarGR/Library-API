<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class LoginController extends Controller
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

    public function login(Request $request)
    {
    
        $user = User::where('email', $request->email)->first();

        //Checar a senha.
        $request['password'] = hash('sha256', $request->password);

        if ($request->password == $user->password)
        {
      
            $id = $user->id;

            $now = new DateTimeImmutable();
            $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText('token_base'));

            $token = $config->builder()
                ->issuedBy('site')
                ->withHeader('iss', 'site')
                ->permittedFor('site')
                ->identifiedBy('user')
                ->relatedTo($id)
                ->issuedAt($now)
                ->expiresAt($now->modify('+100 years'))
                ->withClaim('uid', $id)
                ->getToken($config->signer(), $config->signingKey());
     
            $user->token = $token->toString();

            $user->save();
           
            
            return response()->json([
                'message' => 'Logged in',
                'token' => $token->toString(),
                'name' => $user->name,
                'token teste do teste' => $user->token,  
            ]);

        }

        return response()->json([
            'There was an error on your login. Please try again'
        ], 400);
    }
}
