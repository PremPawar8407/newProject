<table border="1">
	<tr>
		<td>ID </td>
		<td>FIRSTNAME </td>
		<td>LASTNAME </td>
	</tr>
	@foreach ( $data as $value)
	<tr>
		<td>{{$value['id']}} </td>
		<td>{{$value['firstname']}} </td>
		<td>{{$value['lastname']}} </td>
	</tr>	
@endforeach
</table>

{{$data->links()}}

<style>
	.w-5{
		display: none;
	}
</style>

















