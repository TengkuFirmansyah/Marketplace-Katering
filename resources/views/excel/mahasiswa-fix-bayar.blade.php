<table>
	<tr>
		<th colspan="4">
			<h4>Laporan Mahasiswa Fix Bayar {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
		</th>
	</tr>
	<tr>
        <th>Kode Pendaftaran</th>
        <th>Nama Lengkap</th>
        <th>Asal Sekolah</th>
        <th>Jalur</th>
        <th>Prodi</th>
		<th>Tanggal Bayar</th>
		<th>NPM</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$val->code}}</td>
		<td>{{$val->nama_mahasiswa}}</td>
		<td>{{$val->asal_sekolah}}</td>
		<td>{{$val->jalur}}</td>
		<td>{{$val->prodi}}</td>
		<td>{{$val->tanggal_bayar}}</td>
		<td>{{$val->npm}}</td>
	</tr>
	@endforeach
</table>