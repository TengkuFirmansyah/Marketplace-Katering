<table>
	<tr>
		<th>no</th>
		<th>kode pendaftaran</th>
		<th>nama</th>
		<th>no. hp</th>
		<th>data berkas</th>
		<th>data sim</th>
		<th>prodi</th>
	</tr>
	@foreach($data as $key => $val)
	<tr>
		<td>{{$key+1}}</td>
        <td>{{ $val->code }}</td>
        <td>{{ $val->nama }}</td>
        <td>{{ $val->no_hp }}</td>
        <td>
            @if($val->status_berkas == null)
                Kosong
            @elseif($val->status_berkas == 0)
                Revisi
            @elseif($val->status_berkas == 1)
                On Review
            @elseif($val->status_berkas == 2)
                Success
            @endif
        </td>
        <td>
            @if($val->id_sim == null)
                Kosong
            @else
                Success
            @endif
        </td>
        <td>{{$val->nama_prodi}}</td>
	</tr>
	@endforeach
</table>