<!DOCTYPE html>
<html>
<head>
<form action="update_form/{{$data['id']}}" method="POST">
	@csrf 
	<input type="text" name="firstname" value="{{$data['firstname']}}"><br><br>
	<input type="text" name="lastname" value="{{$data['lastname']}}"><br><br>
	<input type="submit" name="save">
</form>
</head>
<body>

</body>
</html>