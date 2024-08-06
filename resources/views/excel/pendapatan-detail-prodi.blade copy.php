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
		<th>Rincian Dana</th>
		<th>Nominal (Rp)</th>
	</tr>
    <?php
        $total1 = 0;
    ?>
	@foreach($data->uangKuliah as $key => $val)
        @if($val->nama == "Semester 1")
            @foreach($val->details as $detail)
                <?php
                    $total1 = $total1 + ($detail->nominal / $val->total) * $data->sudah_bayar_semester_1;
                ?>
                <tr>
                    <td>{{ $detail->rincianDana ? $detail->rincianDana->nama : '-' }}</td>
                    <td>{{ number_format(($detail->nominal / $val->total) * $data->sudah_bayar_semester_1, 2) }}</td>
                </tr>
            @endforeach
        @endif
	@endforeach
	<tr>
        <td><b>Total</b></td>
        <td>{{ number_format($total1,2) }}</td>
	</tr>
    <tr>
        <td></td>
    </tr>
	<tr>
		<th colspan="2">8 Semester</th>
	</tr>
	<tr>
		<th>Rincian Dana</th>
		<th>Nominal (Rp)</th>
	</tr>
    <?php
        $total1 = 0;
    ?>
	@foreach($data->uangKuliah as $key => $val)
        @if($val->nama == "8 Semester")
            @foreach($val->details as $detail)
                <?php
                    $total1 = $total1 + ($detail->nominal / $val->total) * $data->sudah_bayar_semester_8;
                ?>
                <tr>
                    <td>{{ $detail->rincianDana ? $detail->rincianDana->nama : '-' }}</td>
                    <td>{{ number_format(($detail->nominal / $val->total) * $data->sudah_bayar_semester_8, 2) }}</td>
                </tr>
            @endforeach
        @endif
	@endforeach
	<tr>
        <td><b>Total</b></td>
        <td>{{ number_format($total1,2) }}</td>
	</tr>
</table>