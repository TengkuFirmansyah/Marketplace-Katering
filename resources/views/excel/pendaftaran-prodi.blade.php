<table>
		<tr>
			<th colspan="8">
					<h4>Penerimaan Mahasiswa Baru Tahun Ajaran {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
			</th>
		</tr>
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Nama Prodi</th>
			<th rowspan="2">Daftar</th>
			<th colspan="2">Seleksi</th>
			<th colspan="2">Lulus</th>
			<th rowspan="2">Mundur</th>
		</tr>
		<tr>
			<th>Tes</th>
			<th>Bebas Tes</th>
			<th>Tes</th>
			<th>Bebas Tes</th>
		</tr>
		@foreach($data as $key => $val)
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->nama}}</td>
			<td class="text-center">{{$val->daftar}}</td>
			<td class="text-center">{{$val->seleksi_tes}}</td>
			<td class="text-center">{{$val->seleksi_tanpa_tes}}</td>
			<td class="text-center">{{$val->lulus_tes}}</td>
			<td class="text-center">{{$val->lulus_tanpa_tes}}</td>
			<td class="text-center">{{$val->mundur}}</td>
		</tr>
		@endforeach
</table>