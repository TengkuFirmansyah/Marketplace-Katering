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
		<th>hasil_jurusan_{{$i}}</th>
		@endfor
		<th>periode</th>
		<th>keterangan</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$val->code}}</td>
		<td>{{$val->mahasiswa->nama}}</td>
		<td>
			{{isset($val->mahasiswa->pendidikanTerakhir->masterSmaNama) ? $val->mahasiswa->pendidikanTerakhir->masterSmaNama->nama : '-'}}
		</td>
		<td>{{$val->mahasiswa->user->email}}</td>
		<td>
			{{$val->mahasiswa->alamat}}
		</td>
		<td>{{$val->mahasiswa->no_hp}}</td>
		@foreach($val->details as $key => $det)
		<td>{{$det->prodi->nama}}</td>
		<td>
			@if($det->status == 0)
				Menunggu Hasil
			@elseif($det->status == 1)
				Diterima
			@else
				Tidak Diterima
			@endif
		</td>
		@endforeach
		@if(count($val->details) < ($i-1))
		<td>-</td>
		<td>-</td>
		@endif
		<td>
			{{$val->periode->periode_awal}}/{{$val->periode->periode_akhir}} - {{$val->periode->semester}}
		</td>
		<td>{{$val->keterangan}}</td>
	</tr>
	@endforeach
</table>