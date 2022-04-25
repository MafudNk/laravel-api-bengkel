<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        /**Check the validation becomes fails or not
         */
        if ($validator->fails()) {
            /**Return error message
             */
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }
        /**Read the credentials passed by the user
         */
        $credentials = [
            'name' => $request->name,
            'password' => $request->password
        ];

        /**Check the credentials are valid or not
         */
        if (auth()->attempt($credentials)) {
            /**Store the information of authenticated user
             */
            $user = Auth::user();
            /**Create token for the authenticated user
             */

            $success['token'] = "Bearer " . $user->createToken('AppName')->accessToken;
            $success['name'] = $user->name;
            $success['id'] = $user->id;
            $success['email'] = $user->email;
            $success['role'] = $user->role;
            $success['status'] = $user->status;
            // return response()->json(['success' => $success], 200);
            return ResponseFormatter::success($success, 'Login berhasil');
        } else {
            /**Return error message
             */
            return ResponseFormatter::error(null, 'Login gagal', 401);
        }
    }
    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return ResponseFormatter::success($user, 'Logout berhasil');
    }
}
