<!DOCTYPE html>
<html>
<head>
    <title>login</title>
</head>
<form action="login" method="get">
    <input type="name" name="name">@error('name') firstname is invalid @enderror<br><br>
    <input type="password" name="pass">@error('pass') firstname is invalid @enderror<br><br>
    <input type="submit" name="save" value="login">
    @csrf
   
</form>
<body>

</body>
</html>