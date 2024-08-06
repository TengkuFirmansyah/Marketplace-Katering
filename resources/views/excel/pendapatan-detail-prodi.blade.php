<table>
    <tr>
        <th colspan="4">
            <h4>Penerimaan Mahasiswa Baru Tahun Ajaran {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
        </th>
    </tr>
	<tr>
		<th colspan="2"><b>{{$data->nama}}</b></th>
	</tr>
	<tr>
		<th colspan="2">Satu Semester</th>
	</tr>
	<tr>
		<th><b>Mahasiswa</b></th>
		<th><b>Kode Pendaftaran</b></th>
		<th><b>NPM</b></th>
		<th><b>VA</b></th>
		<th><b>Tanggal Buat VA</b></th>
		<th><b>Tanggal Bayar VA</b></th>
		<th><b>Nama Tagihan</b></th>
        @foreach($data->uangKuliah as $key => $val)
            @if($val->nama == "Semester 1")
                @foreach($val->details as $detail)
                    <th><b>{{ $detail->rincianDana ? $detail->rincianDana->nama : '-' }}</b></th>
                @endforeach
            @endif
        @endforeach
	</tr>
    @foreach($mahasiswa1 as $mah)
    <tr>
        <td>{{$mah->nama}}</td>
        <td>{{$mah->code}}</td>
        <td>{{$mah->npm}}</td>
        <td>'{{$mah->va}}</td>
        <td>{{date('Y-m-d', strtotime($mah->created_at))}}</td>
        <td>
            @if($mah->tanggal_bayar == null)
            -
            @else
            {{date('Y-m-d', strtotime($mah->tanggal_bayar))}}
            @endif
        </td>
        <td>{{$mah->nama_va}}</td>
        @foreach($data->uangKuliah as $key => $val)
            @if($val->nama == "Semester 1")
                @foreach($val->details as $detail)
                    <td>{{ ($detail->nominal / $val->total) * $mah->total }}</td>
                @endforeach
            @endif
        @endforeach
    </tr>
    @endforeach
    <tr>
        <td></td>
    </tr>
	<tr>
		<th colspan="2">8 Semester</th>
	</tr>
	<tr>
		<th><b>Mahasiswa</b></th>
		<th><b>Kode Pendaftaran</b></th>
		<th><b>NPM</b></th>
		<th><b>VA</b></th>
		<th><b>Tanggal Buat VA</b></th>
		<th><b>Tanggal Bayar VA</b></th>
		<th><b>Nama Tagihan</b></th>
        @foreach($data->uangKuliah as $key => $val)
            @if($val->nama == "8 Semester")
                @foreach($val->details as $detail)
                    <th><b>{{ $detail->rincianDana ? $detail->rincianDana->nama : '-' }}</b></th>
                @endforeach
            @endif
        @endforeach
	</tr>
    @foreach($mahasiswa8 as $mah)
    <tr>
        <td>{{$mah->nama}}</td>
        <td>{{$mah->code}}</td>
        <td>{{$mah->npm}}</td>
        <td>'{{$mah->va}}</td>
        <td>{{date('Y-m-d', strtotime($mah->created_at))}}</td>
        <td>
            @if($mah->tanggal_bayar == null)
            -
            @else
            {{date('Y-m-d', strtotime($mah->tanggal_bayar))}}
            @endif
        </td>
        <td>{{$mah->nama_va}}</td>
        @foreach($data->uangKuliah as $key => $val)
            @if($val->nama == "8 Semester")
                @foreach($val->details as $detail)
                    <td>{{ ($detail->nominal / $val->total) * $mah->total }}</td>
                @endforeach
            @endif
        @endforeach
    </tr>
    @endforeach
</table>