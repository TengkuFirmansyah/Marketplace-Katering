<table>
	<tr>
		<th>no_pdftn</th>
		<th>nama</th>
		<th>agama</th>
		<th>no_hp</th>
		<th>sekolah_asal</th>
		<th>alamat_sekolah</th>
		<th>periode</th>
		<th>program</th>
		<th>jalur</th>
		<th>prodi_pilihan</th>
		<th>tanggal_test</th>
		<th>keterangan</th>
		<th>pembayaran</th>
		<th>prodi_pilihan</th>
	</tr>
	@foreach($data as $key => $val)
	<?php $ked = -1; ?>
	<tr>
		<td>{{$val->code}}</td>
		<td>{{$val->nama}}</td>
		<td>{{$val->agama}}</td>
		<td>{{$val->no_hp}}</td>
		<td>{{$val->nama_asal}}</td>
		<td>{{$val->provinsi_sekolah}}, {{$val->kabupaten_sekolah}}</td>
		<td>{{$val->periode_awal}}/{{$val->periode_akhir}} - {{$val->semester}}</td>
		<td>{{$val->nama_program}}</td>
		<td>{{$val->nama_jalur}}</td>
		<td>
			@foreach($val->details as $ked => $det)
				@if($ked != 0)
					<br />
				@endif
				{{$ked+1}}. {{$det->nama}}
			@endforeach
		</td>
		@if($ked == -1)
		<td>-</td>
		@else
		<td>{{$val->date != null ? $val->date : '-'}}</td>
		@endif
		<td>{{$val->keterangan}}</td>
		<td>{{$val->bayar != null ? "Bayar" : "Belum Bayar"}}</td>
		<td>{{$val->nama_prodi != null ? $val->nama_prodi : "Belum Pilih Prodi"}}</td>
	</tr>
	@endforeach
</table>