<table>
	<tr>
		<th>Code Pendaftaran</th>
		<th>Nama</th>
		<th>No HP</th>
		<th>No Bangku</th>
		<th>No Ruang</th>
	</tr>
    @foreach($data as $val)
	<tr>
		<th>{{$val->code}}</th>
		<th>{{$val->nama}}</th>
		<th>{{$val->no_hp}}</th>
		<th>{{$val->no_bangku}}</th>
		<th>{{$val->no_ruang}}</th>
	</tr>
    @endforeach
</table>