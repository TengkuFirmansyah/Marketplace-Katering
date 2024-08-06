<table>
	<tr>
		<th>no_pdftn</th>
		<th>nama</th>
		<th>asal_sekolah</th>
		<th>email</th>
		<th>nik</th>
		<th>nisn</th>
		<th>alamat</th>
		<th>no_hp</th>
		@for($i = 1; $i <= $jalur->jumlah_pilihan; $i++)
		<th>jurusan_{{$i}}</th>
		@endfor
		<th>jadwal_test</th>
		<th>periode</th>
		<th>keterangan</th>
		<th>TPA Conversion</th>
		<th>English Conversion</th>
		<th>FEB</th>
		<th>FT</th>
		<th>FF</th>
	</tr>
	@foreach($data as $key => $val)
	@if(count($val->penilaian) > 0)
	<tr>
		<td>{{$val->code}}</td>
		<td>{{$val->mahasiswa->nama}}</td>
		<td>{{$val->mahasiswa->pendidikanTerakhir->masterSmaNama->nama}}</td>
		<td>{{$val->mahasiswa->user->email}}</td>
		<td>'{{$val->mahasiswa->nik}}</td>
		<td>'{{$val->mahasiswa->nisn}}</td>
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
		<td>{{$val->jadwalTest ? $val->jadwalTest->date : '-'}}</td>
		<td>
			{{$val->periode->periode_awal}}/{{$val->periode->periode_akhir}} - {{$val->periode->semester}}
		</td>
		<td>{{$val->keterangan}}</td>
		<th>
			@foreach($val->penilaian as $pen)
				@if($pen->kategori_penilaian == "TPA Conversion")
					{{$pen->nilai}}
				@endif
			@endforeach
		</th>
		<th>
			@foreach($val->penilaian as $pen)
				@if($pen->kategori_penilaian == "English Conversion")
					{{$pen->nilai}}
				@endif
			@endforeach
		</th>
		<th>
			@foreach($val->penilaian as $pen)
				@if($pen->kategori_penilaian == "FEB")
					{{$pen->nilai}}
				@endif
			@endforeach
		</th>
		<th>
			@foreach($val->penilaian as $pen)
				@if($pen->kategori_penilaian == "FT")
					{{$pen->nilai}}
				@endif
			@endforeach
		</th>
		<th>
			@foreach($val->penilaian as $pen)
				@if($pen->kategori_penilaian == "FF")
					{{$pen->nilai}}
				@endif
			@endforeach
		</th>
	</tr>
	@endif
	@endforeach
</table>