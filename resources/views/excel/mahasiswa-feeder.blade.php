<table>
	<tr>
		<th colspan="15">
			<h4>Laporan Mahasiswa Feeder {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
		</th>
	</tr>
	<tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>NIK</th>
        <th>Agama</th>
        <th>NISN</th>
        <th>Jalur Pendaftaran</th>
        <th>Kewarganegaraan</th>
        <th>Jenis Pendaftaran</th>
        <th>Tgl Masuk Kuliah</th>
        <th>Mulai semester</th>
        <th>Jalan</th>
        <th>RT</th>
        <th>RW</th>
        <th>Nama Dusun</th>
        <th>Kelurahan</th>
        <th>Kecamatan</th>
        <th>Kode Pos</th>
        <th>Tempat Tinggal</th>
        <th>No HP</th>
        <th>Email</th>
        <th>Nama Bapak</th>
        <th>Pendidikan Bapak</th>
        <th>Pekerjaan Bapak</th>
        <th>Penghasilan Ortu</th>
        <th>Terima KPS</th>
        <th>Nama Ibu</th>
        <th>Pendidikan Ibu</th>
        <th>Pekerjaan Ibu</th>
        <th>Beasiswa</th>
        <th>Kode Prodi</th>
        <th>Jenis Pembayaran</th>
        <th>Total Pembiayaan</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$val->npm}}</td>
		<td>{{$val->nama}}</td>
		<td>{{$val->tempat_lahir}}</td>
		<td>{{$val->tanggal_lahir}}</td>
		<td>{{$val->jenis_kelamin}}</td>
		<td>&nbsp;{{$val->nik}}</td>
		<td>{{$val->agama}}</td>
		<td>&nbsp;{{$val->nisn}}</td>
		<td>{{$val->nama_jalur}}</td>
        <td></td>
		<td>{{$val->jenis_pendaftaran}}</td>
        <td></td>
		<td>{{$val->periode_awal.($val->semester == 'Gasal' ? '1' : '2')}}</td>
		<td>{{$val->alamat}}</td>
		<td>&nbsp;{{ sprintf("%03s", $val->rt)}}</td>
		<td>&nbsp;{{ sprintf("%03s", $val->rw)}}</td>
        <td></td>
		<td>{{$val->kelurahan}}</td>
		<td>{{$val->kecamatan}}</td>
		<td>{{$val->kode_pos}}</td>
		<td>{{$val->tempat_tinggal}}</td>
		<td>{{$val->no_hp}}</td>
		<td>{{$val->email}}</td>
		<td>{{$val->nama_bapak}}</td>
		<td>{{$val->pendidikan_bapak}}</td>
		<td>{{$val->pekerjaan_bapak}}</td>
		<td>{{$val->penghasilan_ortu}}</td>
        <td></td>
		<td>{{$val->nama_ibu}}</td>
		<td>{{$val->pendidikan_ibu}}</td>
		<td>{{$val->pekerjaan_ibu}}</td>
		<td>{{$val->beasiswa}}</td>
		<td>{{$val->kode_prodi}}</td>
		<td>{{$val->tipe_pembayaran}}</td>
		<td>{{$val->total_pembayaran}}</td>
	</tr>
	@endforeach
</table>