<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
table, td, th {  
  border: 1px solid #006ac5;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 5px;
}
th{
	color: #fff;
	text-align: center;
	background-color: #4eadff;
}
.text-center {
	text-align: center;
}
.text-right {
	text-align: right;
}
</style>
<h4>Laporan Kuesioner Mahasiswa {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}. {{$program->nama}} - {{$program->masterJenjangPendaftaran->nama}}</h4>
<table>
	<thead>
		<tr>
			<th width="10px">No</th>
			<th>Sumber Informasi</th>
      		<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach($sumberInformasi as $key => $val)
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->sumber_informasi}}</td>
      		<td class="text-right">{{$val->jumlah}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
<table style="page-break-before: always">
	<thead>
		<tr>
			<th width="10px">No</th>
			<th>Kriteria PT</th>
      		<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach($kriteriaPt as $key => $val)
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->kriteria_pt}}</td>
      		<td class="text-right">{{$val->jumlah}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
<table style="page-break-before: always">
	<thead>
		<tr>
			<th width="10px">No</th>
			<th>Alasan Masuk</th>
      		<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach($alasanMasuk as $key => $val)
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->alasan_masuk}}</td>
      		<td class="text-right">{{$val->jumlah}}</td>
		</tr>
		@endforeach
	</tbody>
</table>