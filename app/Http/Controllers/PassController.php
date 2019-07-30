<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Illuminate\Http\Request;

class PassController extends Controller
{
    public function reset(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
            }
        $password= bcrypt($request['password']);
        $kode= $request['kode'];
        $user= User::where('id', '=', $id)->where('kode', '=', $kode)->first();
        $user->update([
			'password' => $password
		]);
        return response()->json('password updated');
        }
}
