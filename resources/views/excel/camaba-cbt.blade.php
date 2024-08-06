<table>
	<tr>
		<th>no_pdftn</th>
		<th>nama</th>
		<th>asal_sekolah</th>
		<th>email</th>
		<th>alamat</th>
		<th>no_hp</th>
		@for($i = 1; $i <= $jalur->jumlah_pilihan; $i++)
		<th>jurusan_{{$i}}</th>
		@endfor
		<th>jadwal_test</th>
		<th>periode</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$val->code}}</td>
		<td>{{$val->mahasiswa->nama}}</td>
		<td>{{$val->mahasiswa->pendidikanTerakhir->masterSmaNama->nama}}</td>
		<td>{{$val->mahasiswa->user->email}}</td>
		<td>
			{{$val->mahasiswa->alamat}}
		</td>
		<td>{{$val->mahasiswa->no_hp}}</td>
		@foreach($val->details as $key => $det)
		<td>{{$det->prodi->nama}}</td>
		@endforeach
		@if(count($val->details) < ($i-1))
		<td>-</td>
		@endif
		<td>{{$val->jadwalTest->date}}</td>
		<td>
			{{$val->periode->periode_awal}}/{{$val->periode->periode_akhir}} - {{$val->periode->semester}}
		</td>
	</tr>
	@endforeach
</table>