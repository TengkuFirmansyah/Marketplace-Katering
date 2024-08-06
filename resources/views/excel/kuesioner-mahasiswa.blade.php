<table>
	<tr>
		<th colspan="3">
			<h4>Laporan Kuesioner Mahasiswa {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}. {{$program->nama}} - {{$program->masterJenjangPendaftaran->nama}} </h4>
		</th>
	</tr>
	<tr>
		<th width="10px">No</th>
		<th>Sumber Informasi</th>
		<th>Jumlah</th>
	</tr>
	@foreach($sumberInformasi as $key => $val)
	<tr>
		<td class="text-right">{{$key+1}}</td>
		<td>{{$val->sumber_informasi}}</td>
		<td class="text-right">{{$val->jumlah}}</td>
	</tr>
	@endforeach
	<tr><th></th></tr>
	<tr>
		<th width="10px">No</th>
		<th>Kriteria PT</th>
		<th>Jumlah</th>
	</tr>
	@foreach($kriteriaPt as $key => $val)
	<tr>
		<td class="text-right">{{$key+1}}</td>
		<td>{{$val->kriteria_pt}}</td>
		<td class="text-right">{{$val->jumlah}}</td>
	</tr>
	@endforeach
	<tr><th></th></tr>
	<tr>
		<th width="10px">No</th>
		<th>Alasan Masuk</th>
		<th>Jumlah</th>
	</tr>
	@foreach($alasanMasuk as $key => $val)
	<tr>
		<td class="text-right">{{$key+1}}</td>
		<td>{{$val->alasan_masuk}}</td>
		<td class="text-right">{{$val->jumlah}}</td>
	</tr>
	@endforeach
</table>