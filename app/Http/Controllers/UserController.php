<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();
        return ResponseFormatter::success($user, 'data user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**Validate the data using validation rules
        */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
            
        /**Check the validation becomes fails or not
        */
        if ($validator->fails()) {
            /**Return error message
            */
            return response()->json([ 'error'=> $validator->errors() ]);
        }

        /**Store all values of the fields
        */
        $newuser = $request->all();

            /**Create an encrypted password using the hash
        */
        $newuser['password'] = Hash::make($newuser['password']);

        /**Insert a new user in the table
        */
        $user = User::create($newuser);
        $success['user'] =$user;
            /**Create an access token for the user
        */
        $success['token'] = $user->createToken('AppName')->accessToken;
        /**Return success message with token value
        */
        return response()->json(['success'=>$success], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        
        $user->save();
        return ResponseFormatter::success($user, 'sukses');
    }
    public function update_post(Request $request, $id)
    {
        $user = User::find($id);
 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        
        $user->save();
        return ResponseFormatter::success($user, 'sukses');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
