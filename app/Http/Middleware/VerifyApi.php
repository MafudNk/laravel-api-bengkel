<?php

namespace App\Http\Middleware;

use App\Entities\OauthAccessTokens as EntitiesOauthAccessTokens;
use App\Entities\User;
use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class VerifyApi
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
        $user = Auth::user();
        $userSerialize = serialize($user);
        $userUnserializeArray = (array) unserialize($userSerialize);

        $arrayKeys = array_keys($userUnserializeArray);
        foreach ($arrayKeys as $value)
        {

            if (strpos($value, 'accessToken') !== false) {

                $userAccessTokenArray = (array) $userUnserializeArray[$value];
                $arrayAccessKeys = array_keys($userAccessTokenArray);
                foreach ($arrayAccessKeys as $arrayAccessValue) {

                    if (strpos($arrayAccessValue, 'original') !== false) {

                        $userTokenId = $userAccessTokenArray[$arrayAccessValue]['id'];
                        $checkToken = EntitiesOauthAccessTokens::where([
                            ['id', '=', $userTokenId],
                            ['expires_at', '>', Carbon::now()]
                        ])->first();

                        if ( !$checkToken ) {
                            
                            ResponseFormatter::error(null, 'Token time has expired. Please log in again.', 401);
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
