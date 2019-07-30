Hello <strong>{{ $nama }}</strong>,
<p>Please Click on the link to verify your email.</p>
<br>
<form method='POST' action="{{url('api/email/verify/'.$id)}}">
    <input type="hidden" name="kode" value="{{$kode}}">
    <button id="submit" type="submit">Verify me</button>
</form>