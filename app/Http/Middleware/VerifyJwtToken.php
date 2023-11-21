<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
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
                return ResponseHelper::jsonResponse(401,"ser_not_found",null,true);
            }
        } catch (TokenExpiredException $e) {
            $token = JWTAuth::parseToken()->refresh();
            return ResponseHelper::jsonResponse(401,"token_expired",['token'=>$token],true);

        } catch (TokenInvalidException $e) {

            return ResponseHelper::jsonResponse(401,"token_invalid",null,true);
        } catch (JWTException $e) {

            return ResponseHelper::jsonResponse(401,"token_absent",null,true);

        }
        catch (JWTException $e) {
            return ResponseHelper::jsonResponse(401,"invalid_token",null,true);
        } 
        return $next($request);
    }
}