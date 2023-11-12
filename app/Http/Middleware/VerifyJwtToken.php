<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class VerifyJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return response()->json(["message"=>'user_not_found',"data"=>null,"error"=>true]);
            }

        } catch (TokenExpiredException $e) {
            $token = JWTAuth::parseToken()->refresh();
            return response()->json(["message"=>'token_expired',"error"=> true,"data"=>$token]);

        } catch (TokenInvalidException $e) {

            return response()->json(["message"=>'token_invalid',"data"=>null,"error"=>true] );

        } catch (JWTException $e) {

            return response()->json(['token_absent',"data"=>null,"error"=>true]);

        }
        catch (JWTException $e) {
            return response()->json(['message' => 'invalid token',"data"=>null,"error"=>true]);
        } 
        return $next($request);
    }
}