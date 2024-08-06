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
			<!-- @if($pilihan != "Keseluruhan") -->
			<!-- @else
			<th rowspan="3">Bayar 1</th>
			<th rowspan="3">Bayar 2</th>
			<th colspan="2">Mundur</th>
			<th colspan="2">Fix Bayar</th>
			@endif -->
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
			$sebelum = findArrayObject($val->code, $dataprev, 'prodikode');
			$dikosongkan = ['53','63','54','64','72','01','02','03','04','05','06']
		?>
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->nama}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['daftar'] != null ? $sebelum['daftar'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->daftar}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['seleksites'] != null ? $sebelum['seleksites'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['seleksibebastes'] != null ? $sebelum['seleksibebastes'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->seleksi_tes}}</td>
			<td class="text-center">{{$val->seleksi_tanpa_tes}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['lulustes'] != null ? $sebelum['lulustes'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['lulusbebastes'] != null ? $sebelum['lulusbebastes'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->lulus_tes}}</td>
			<td class="text-center">{{$val->lulus_tanpa_tes}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['mundur'] != null ? $sebelum['mundur'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->mundur}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['bayar'] != null ? $sebelum['bayar'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->fix_bayar}}</td>
			<!-- @if($pilihan != "Keseluruhan") -->
			<!-- @else
			<td class="text-center">{{$val->fix_bayar}}</td>
			<td class="text-center">{{$val->fix_bayar_2}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['mundur'] != null ? $sebelum['mundur'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->mundur}}</td>
			<td class="text-center">
				@if($sebelum)
				@if(in_array($val->code, $dikosongkan))
					0
				@else
					{{ $sebelum['bayar'] != null ? $sebelum['bayar'] : 0 }}
				@endif
				@else
				0
				@endif
			</td>
			<td class="text-center">{{$val->fix_bayar_1 + $val->fix_bayar_2}}</td>
			@endif -->
		</tr>
		@endforeach
</table>