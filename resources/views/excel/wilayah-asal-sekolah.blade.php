<table>
	<tr>
		<th colspan="5">
			<h4>Laporan Wilayah Asal Sekolah {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}. {{$program->nama}} - {{$program->masterJenjangPendaftaran->nama}} </h4>
		</th>
	</tr>
	<tr>
		<th>No</th>
		<th>Provinsi</th>
		<th>Kabupaten / Kota</th>
		<th>Nama Sekolah</th>
		<th>Jumlah</th>
		<th>%</th>
	</tr>
	<?php $total = 0; ?>
	@foreach($data as $key => $val)
	<?php $total = $total + $val->jumlah; ?>
	@endforeach
	@foreach($data as $key => $val)
	<tr>
		<td class="text-right">{{$key+1}}</td>
		<td>{{ $val->provinsi }}</td>
		<td>{{ $val->kota }}</td>
		<td>{{ $val->nama }}</td>
		<td class="text-right">{{$val->jumlah}}</td>
		<td>{{ number_format(($val->jumlah / $total) * 100, 2) }}%</td>
	</tr>
	@endforeach
	<tr>
		<td colspan="4">Total</td>
		<td>{{$total}}</td>
		<td>100%</td>
	</tr>
</table>