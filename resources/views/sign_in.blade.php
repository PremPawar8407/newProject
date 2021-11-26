<!DOCTYPE html>
<html>
<head>
    <title>login</title>
</head>
<form action="log" method="get">
 firstname:   <input type="name" name="firstname"> @error('firstname') firstname is invalid @enderror<br><br>
 password:   <input type="password" name="password"> @error('password') password is invalid @enderror<br><br>
    <input type="submit" name="save" value="login">
    @csrf
   
   
   
</form>
<body>

</body>
</html>