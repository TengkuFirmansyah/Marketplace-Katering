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
<h4>Laporan Almamater Berdasarkan Ukuran {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}. {{$program->nama}} - {{$program->masterJenjangPendaftaran->nama}}</h4>
<table>
	<thead>
		<tr>
			<th width="10px">No</th>
      <th>Nama Prodi</th>
      <th>S</th>
      <th>M</th>
      <th>L</th>
      <th>XL</th>
      <th>XXL</th>
      <th>XXXL</th>
      <th>JUMBO</th>
		</tr>
	</thead>
	<tbody>
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
	</tbody>
</table>