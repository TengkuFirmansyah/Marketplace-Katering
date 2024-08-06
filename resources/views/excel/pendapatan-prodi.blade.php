<table>
    <tr>
        <th colspan="5">
                <h4>Penerimaan Mahasiswa Baru Tahun Ajaran {{$tahun->semester}} {{$tahun->periode_awal}}/{{$tahun->periode_akhir}}</h4>
        </th>
    </tr>
	<tr>
		<th>no</th>
		<th>Prodi</th>
		<th>Total</th>
		<th>Sudah Bayar</th>
		<th>Belum Bayar</th>
		<th>Sumbangan Sudah Bayar</th>
		<th>Sumbangan Belum Bayar</th>
		<th>Daftar Ulang Sudah Bayar</th>
		<th>Daftar Ulang Belum Bayar</th>
		<th>Biaya Pendaftaran Sudah Bayar</th>
		<th>Biaya Pendaftaran Belum Bayar</th>
	</tr>
    <?php
        $total = 0;
        $sudah_bayar = 0;
        $belum_bayar = 0;
        $sudah_bayar_sumbangan = 0;
        $belum_bayar_sumbangan = 0;
        $sudah_bayar_daftar_ulang = 0;
        $belum_bayar_daftar_ulang = 0;
        $sudah_bayar_pendaftaran = 0;
        $belum_bayar_pendaftaran = 0;
    ?>
	@foreach($data as $key => $val)
    <?php
        $total = $total + $val->total;
        $sudah_bayar = $sudah_bayar + $val->sudah_bayar;
        $belum_bayar = $belum_bayar + $val->belum_bayar;
        $sudah_bayar_sumbangan = $sudah_bayar_sumbangan + $val->sudah_bayar_sumbangan;
        $belum_bayar_sumbangan = $belum_bayar_sumbangan + $val->belum_bayar_sumbangan;
        $sudah_bayar_daftar_ulang = $sudah_bayar_daftar_ulang + $val->sudah_bayar_daftar_ulang;
        $belum_bayar_daftar_ulang = $belum_bayar_daftar_ulang + $val->belum_bayar_daftar_ulang;
        $sudah_bayar_pendaftaran = $sudah_bayar_pendaftaran + $val->sudah_bayar_pendaftaran;
        $belum_bayar_pendaftaran = $belum_bayar_pendaftaran + $val->belum_bayar_pendaftaran;
    ?>
	<tr>
		<td>{{$key+1}}</td>
        <td>{{ $val->nama }}</td>
        <td>{{ number_format($val->total,2) }}</td>
        <td>{{ number_format($val->sudah_bayar,2) }}</td>
        <td>{{ number_format($val->belum_bayar,2) }}</td>
        <td>{{ number_format($val->sudah_bayar_sumbangan,2) }}</td>
        <td>{{ number_format($val->belum_bayar_sumbangan,2) }}</td>
        <td>{{ number_format($val->sudah_bayar_daftar_ulang,2) }}</td>
        <td>{{ number_format($val->belum_bayar_daftar_ulang,2) }}</td>
        <td>{{ number_format($val->sudah_bayar_pendaftaran,2) }}</td>
        <td>{{ number_format($val->belum_bayar_pendaftaran,2) }}</td>
	</tr>
	@endforeach
	<tr>
        <td colspan="2">Total</td>
        <td>{{ number_format($total,2) }}</td>
        <td>{{ number_format($sudah_bayar,2) }}</td>
        <td>{{ number_format($belum_bayar,2) }}</td>
        <td>{{ number_format($sudah_bayar_sumbangan,2) }}</td>
        <td>{{ number_format($belum_bayar_sumbangan,2) }}</td>
        <td>{{ number_format($sudah_bayar_daftar_ulang,2) }}</td>
        <td>{{ number_format($belum_bayar_daftar_ulang,2) }}</td>
        <td>{{ number_format($sudah_bayar_pendaftaran,2) }}</td>
        <td>{{ number_format($belum_bayar_pendaftaran,2) }}</td>
	</tr>
</table>