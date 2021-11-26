<!DOCTYPE html>
<html>
	<h1>CRUD table</h1>

	<table border="2">
		<tr>
			<td>ID</td>
			<td>firstname</td>
			<td>lastname</td>
		</tr>
		@foreach ($data as $value)
		<tr>
			<td>{{$value['id']}} </td>
			<td>{{$value['firstname']}} </td>
			<td>{{$value['lastname']}} </td>
			<td><a href="delete/{{$value['id']}}">delete</a></td>
			<td><a href="update/{{$value['id']}}">edit</a></td>
		</tr>
		@endforeach
	</table>
	<a href="insert">insert value</a>

</html>

