<table>
	<tr>
		<th colspan="3">
			<h4>Laporan Sebaran Berdasarkan Suku {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
		</th>
	</tr>
	<tr>
		<th>No</th>
		<th>Nama Suku</th>
		<th>Jumlah</th>
		<th>%</th>
	</tr>
	<?php $total = 0; ?>
	@foreach($data as $key => $val)
	<?php $total = $total + $val->total; ?>
	@endforeach
	@foreach($data as $key => $val)
	<tr>
		<td class="text-right">{{$key+1}}</td>
		<td>{{$val->nama}}</td>
		<td>{{$val->total}}</td>
		<td>{{ number_format(($val->total / $total) * 100, 2) }}%</td>
	</tr>
	@endforeach
	<tr>
		<td colspan="2">Total</td>
		<td>{{$total}}</td>
		<td>100%</td>
	</tr>
</table>