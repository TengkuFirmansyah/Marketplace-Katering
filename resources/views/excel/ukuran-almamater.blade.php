<table>
	<tr>
		<th colspan="9">
			<h4>Laporan Almamater Berdasarkan Ukuran {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}. {{$program->nama}} - {{$program->masterJenjangPendaftaran->nama}} </h4>
		</th>
	</tr>
	<tr>
		<th>No</th>
		<th>Nama Prodi</th>
		<th>S</th>
		<th>M</th>
		<th>L</th>
		<th>XL</th>
		<th>XXL</th>
		<th>XXXL</th>
		<th>JUMBO</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td class="text-right">{{$key+1}}</td>
		<td>{{$val->nama}}</td>
		<td>{{$val->ukuran_s}}</td>
		<td>{{$val->ukuran_m}}</td>
		<td>{{$val->ukuran_l}}</td>
		<td>{{$val->ukuran_xl}}</td>
		<td>{{$val->ukuran_xxl}}</td>
		<td>{{$val->ukuran_xxxl}}</td>
		<td>{{$val->ukuran_jumbo}}</td>
	</tr>
	@endforeach
</table>