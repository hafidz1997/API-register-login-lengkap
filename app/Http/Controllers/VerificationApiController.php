<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
class VerificationApiController extends Controller
{
// use VerifiesEmails;

// public function show()
// {

// }

//verifikasi email
public function verify(Request $request, $id) {
$kode= $request['kode'];
$user= User::where('id', '=', $id)->where('kode', '=', $kode)->first();
$date = date("Y-m-d g:i:s");
$user->email_verified_at = $date;
$user->save();
return response()->json('Email verified!');
}



//resend email
// public function resend(Request $request)
// {
// if ($request->user()->hasVerifiedEmail()) {
// return response()->json('User already have verified email!', 422);

// }
// $request->user()->sendEmailVerificationNotification();
// return response()->json('The notification has been resubmitted');

// }
}