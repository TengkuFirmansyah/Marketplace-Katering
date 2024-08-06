<table>
		<tr>
			<th colspan="8">
					<h4>Penerimaan Mahasiswa Baru Tahun Ajaran {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
			</th>
		</tr>
		<tr>
			<th rowspan="3">No</th>
			<th rowspan="3">Nama Prodi</th>
			<th colspan="2">Daftar</th>
			<th colspan="4">Seleksi</th>
			<th colspan="4">Lulus</th>
			<th colspan="2">Mundur</th>
			<th colspan="2">Fix Bayar</th>
		</tr>
		<tr>
			<th rowspan="2">Sebelumnya</th>
			<th rowspan="2">Sekarang</th>
			<th colspan="2">Sebelumnya</th>
			<th colspan="2">Sekarang</th>
			<th colspan="2">Sebelumnya</th>
			<th colspan="2">Sekarang</th>
			<th rowspan="2">Sebelumnya</th>
			<th rowspan="2">Sekarang</th>
			<th rowspan="2">Sebelumnya</th>
			<th rowspan="2">Sekarang</th>
		</tr>
		<tr>
			<th>Tes</th>
			<th>Bebas Tes</th>
			<th>Tes</th>
			<th>Bebas Tes</th>
			<th>Tes</th>
			<th>Bebas Tes</th>
			<th>Tes</th>
			<th>Bebas Tes</th>
		</tr>
		@foreach($data as $key => $val)
		<?php 
			$sebelum = findArrayObjectNew($val->code, $dataprev);
			$dikosongkan = ['53','63','54','64','72','01','02','03','04','05','06']
		?>
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->nama}}</td>
			<td class="text-center">{{$sebelum->daftar}}</td>
			<td class="text-center">{{$val->daftar}}</td>
			<td class="text-center">{{$sebelum->seleksi_tes}}</td>
			<td class="text-center">{{$sebelum->seleksi_tanpa_tes}}</td>
			<td class="text-center">{{$val->seleksi_tes}}</td>
			<td class="text-center">{{$val->seleksi_tanpa_tes}}</td>
			<td class="text-center">{{$sebelum->lulus_tes}}</td>
			<td class="text-center">{{$sebelum->lulus_tanpa_tes}}</td>
			<td class="text-center">{{$val->lulus_tes}}</td>
			<td class="text-center">{{$val->lulus_tanpa_tes}}</td>
			<td class="text-center">{{$sebelum->mundur}}</td>
			<td class="text-center">{{$val->mundur}}</td>
			<td class="text-center">{{$sebelum->fix_bayar}}</td>
			<td class="text-center">{{$val->fix_bayar}}</td>
		</tr>
		@endforeach
</table>