<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = '';

        //Se houver um token, e ele não for nulo (não definido)
        if ($request->bearerToken() && $request->bearerToken() != "undefined")
        {
            $token = $request->bearerToken();

          
            $user = User::where('token', $token)->first();
            
            //Se não houver
             if (!$user){
                return response()->json([
                    'message' => 'Unautorized Access'
                ], 401);
             }
                
          
            $id = $user->id;

            $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText('token_base'));

            $token_parsed = $config->parser()->parse($token);

            //Regras
            $constraints = [
                //O token é relacionado a este usuário mesmo?
                new RelatedTo($id),
                //É permitido ser usado aqui?
                new PermittedFor('site'),
                //É desta categoria?
                new IdentifiedBy('user')
            ];

           
            if ($config->validator()->validate($token_parsed, ...$constraints)){
                $nada = 'coisa nenhuma';
            }
            else{
                return response()->json([
                    'message' => 'Unautorized Access'
                ], 401);
            }
        }
      
        else
        {
            return response()->json([
                        'message' => 'Unautorized Access'
                    ], 401);
        }

        

        return $next($request);
    }
}
