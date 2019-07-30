Hello <strong>{{ $nama }}</strong>,
<p>Please Enter your new password.</p>
<br>
<form method='POST' action="{{url('api/pass/reset/'.$id)}}">
    <input type="hidden" name="kode" value="{{$kode}}">
    <label>Password</label>
    <input type="password" name="password" >
    <label>Confirmation Password</label>
    <input type="password" name="c_password">
    <button id="submit" type="submit">save password</button>
</form>