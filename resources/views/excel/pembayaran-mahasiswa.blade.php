<table>
	<tr>
		<th>No</th>
		<th>Code Pendaftaran</th>
		<th>Nama</th>
		<th>Jurusan</th>
		<th>No VA</th>
		<th>Prefix</th>
		<th>Nominal</th>
		<th>Tgl Rekon</th>
		<th>Status Pembayaran</th>
		<th>Tgl Bayar</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
        <td>{{$key+1}}</td>
		<td>{{$val->code}}</td>
		<td>{{$val->mahasiswa}}</td>
		<td>{{$val->prodi}}</td>
		<td>'{{$val->va}}</td>
		<td>{{$val->nama}}</td>
		<td>{{number_format($val->nominal)}}</td>
		<td>{{$val->tanggal_expired}}</td>
		<td>{{ $val->status == 1 ? 'Lunas' : 'Belum Bayar' }}</td>
		<td>{{$val->tanggal_bayar}}</td>
	</tr>
	@endforeach
</table>