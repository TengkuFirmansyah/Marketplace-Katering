<table>
    <tr>
        <th colspan="5">
            <h4>Laporan Jumlah Pendaftaran {{ $tahun->semester }}
                {{ $tahun->periode_awal }}/{{ $tahun->periode_akhir }}</h4>
        </th>
    </tr>
    <tr>
		<th>No</th>
		<th>Periode</th>
		<th>Jenjang Pendaftaran</th>
		<th>Program</th>
		<th>Nama Jalur</th>
		<th>Daftar</th>
		<th>Lulus</th>
		<th>Sudah Bayar</th>
    </tr>
    @foreach($data as $key => $val)
	<tr>
		<td>{{ $key+1 }}</td>
		<td>{{ $val->masterPeriode ? $val->masterPeriode->periode_awal.'/'.$val->masterPeriode->periode_akhir.'-'.$val->masterPeriode->semester : '-' }}</td>
		<td>{{ $val->masterJenjangPendaftaran ? $val->masterJenjangPendaftaran->nama : '-' }}</td>
		<td>{{ $val->masterProgram ? $val->masterProgram->nama : '-' }}</td>
		<td>{{ $val->nama }}</td>
		<td>{{ $val->total_pendaftar }}</td>
		<td>{{ $val->total_lulus }}</td>
		<td>{{ $val->total_bayar }}</td>
	</tr>
    @endforeach
</table>