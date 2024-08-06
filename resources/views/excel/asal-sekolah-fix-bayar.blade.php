<table>
	<tr>
		<th colspan="2">
			<h4>Laporan Asal Sekolah Fix Bayar {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
		</th>
	</tr>
	<tr>
		<th>Nama Lengkap</th>
        <th>Total Fix Bayar</th>
	</tr>
	<?php $total = 0; ?>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$val->nama}}</td>
		<td>{{$val->total}}</td>
	</tr>
	<?php $total = $total + $val->total; ?>
	@endforeach
	<tr>
		<td>Total</td>
		<td>{{$total}}</td>
	</tr>
</table>