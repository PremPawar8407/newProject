<h1>data serch</h1>
<!DOCTYPE html>
<html>
<head>
	<table border="1">
<tr>
	<td>Id</td>
	<td>firstname</td>
	<td>lastname</td>
</tr>
</head>
<body>
	@foreach($data as $value)
	<tr>
	<td>{{$value['id']}}</td>
	<td>{{$value['firstname']}}</td>
	<td>{{$value['lastname']}}</td>
	</tr>
	@endforeach
</table>
</body>
</html>