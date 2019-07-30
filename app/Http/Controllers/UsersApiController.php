<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Auth;
use Mail;
use App\Mail\verifyEmail;
use Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
class UsersApiController extends Controller
{
use VerifiesEmails;
public $successStatus = 200;

//login
public function login(){
if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
$user = Auth::user();
if($user->email_verified_at !== NULL){
$success['message'] = "Login successfull";
return response()->json(['success' => $success], $this-> successStatus);
}else{
return response()->json(['error'=>'Please Verify Email'], 401);
}
}
else{
return response()->json(['error'=>'Unauthorized'], 401);
}
}

//register
public function register(Request $request)
{
$validator = Validator::make($request->all(), [
'username' => 'required',
'email' => 'required|email',
'password' => 'required',
'c_password' => 'required|same:password',
'nama' => 'required', 
'alamat' => 'required', 
'gender' => 'required', 
'telepon' => 'required', 
'instansi' => 'required' 
]);
if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
    }

else{
        $email = $request['email'];
        $username = $request['username'];
        if(User::where('email', '=', $email)->exists()){
            return response()->json([
            'success'=>false,
            'message'=>'Email sudah terdaftar',
            'Status' => 409
            ], 409);
        }
        else{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['kode'] = Str::random(40);
            $user = User::create($input);
            $thisUser = User::findOrFail($user->id);
            $this->sendEmail($thisUser);

            $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
            return response()->json(['success'=>$success], $this-> successStatus);
        }
    }
}

//send email pas regist
public function sendEmail($thisUser)
{
$to_name = $thisUser['nama'];
$to_email = $thisUser['email'];
$data = array('kode'=>$thisUser['kode'], 'nama'=>$thisUser['nama'],'id'=>$thisUser['id']);
Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
$message->to($to_email, $to_name)
->subject('Laravel Test Mail');
$message->from('hafidzuddink@gmail.com','Test Mail');
});
}



//masukin email buat dikirim reset pass
public function forgot(Request $request)
{
$validator = Validator::make($request->all(), [
'email' => 'required|email'
]);
if ($validator->fails()) {
return response()->json(['error'=>$validator->errors()], 401);
}
$input = $request['email'];
if (User::where('email',$input)->exists()) {
    $thisUser = User::where('email',$input)->first();
    $this->sendForgot($thisUser);
    $success['message'] = 'Please check your email';
    return response()->json(['success'=>$success], $this-> successStatus);
 }
else{
    return response()->json(['error'=>'email not registered'], 401);
    }
}

//ngirim email forgot pass
public function sendForgot($thisUser)
{
$nama = $thisUser->nama;
$to_email = $thisUser->email;
$id = $thisUser->id;
$kode = $thisUser->kode;
$data = array('kode'=>$kode, 'nama'=>$nama,'id'=>$id);
Mail::send('email.mail2', $data, function($message) use ($nama, $to_email) {
$message->to($to_email, $nama)
->subject('Laravel Test Mail');
$message->from('hafidzuddink@gmail.com','Test Mail');
});
}

}