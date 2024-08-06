<table>
	<tr>
		<th colspan="15">
			<h4>Laporan NPM Mahasiswa {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
		</th>
	</tr>
	<tr>
        <th>NPM</th>
        <th>Nama Lengkap</th>
        <th>Program Studi</th>
        <th>Fakultas</th>
        <th>Jenjang</th>
        <th>Jenis Kelamin (L/P)</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir (Y-m-d)</th>
        <th>Agama</th>
        <th>Email</th>
        <th>NIK</th>
        <th>No. HP</th>
        <th>No Pendaftaran</th>
        <th>Status Mahasiswa</th>
        <th>Jalur</th>
        <th>Type Pembayaran</th>
        <th>Status Beasiswa</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$val->npm}}</td>
		<td>{{$val->nama}}</td>
		<td>{{$val->nama_prodi}}</td>
		<td>{{$val->nama_fakultas}}</td>
		<td>{{$val->nama_jenjang}}</td>
		<td>{{$val->jenis_kelamin}}</td>
		<td>{{$val->tempat_lahir}}</td>
		<td>{{$val->tanggal_lahir}}</td>
		<td>{{$val->agama}}</td>
		<td>{{$val->email}}</td>
		<td>'{{$val->nik}}</td>
		<td>{{$val->no_hp}}</td>
		<td>{{$val->code}}</td>
		<td>{{$val->keterangan}}</td>
		<td>{{$val->nama_jalur}}</td>
		<td>{{$val->tipe_pembayaran}}</td>
		<td>{{$val->beasiswa}}</td>
	</tr>
	@endforeach
</table>