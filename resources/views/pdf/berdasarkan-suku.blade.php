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
<h4>Laporan Sebaran Berdasarkan Suku {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
<table>
	<thead>
		<tr>
			<th width="10px">No</th>
			<th>Nama Suku</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $key => $val)
		<tr>
			<td class="text-right">{{$key+1}}</td>
			<td>{{$val->nama}}</td>
			<td>{{$val->total}}</td>
		</tr>
		@endforeach
	</tbody>
</table>