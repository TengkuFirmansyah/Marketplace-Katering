<table class="table table-hover table-rounded table-striped border gy-7 gs-7 text-nowrap">
    <thead>
        <tr class="fw-bold fs-5 text-gray-800 border-bottom-2 border-gray-200">
            <th>No</th>
            <th>No Pendaftaran</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>No. HP</th>
            <th>Asal Sekolah</th>
            <th>Status Pembayaran</th>
            <th>Lulus Berkas</th>
            @foreach($file as $fi)
                <th>{{ $fi->nama }}</th>
                <th> &lt; Status Berkas</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $val)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $val->code}}</td>
            <td>{{ $val->mahasiswa ? $val->mahasiswa->nama : '-' }}</td>
            <td>{{ $val->mahasiswa ? $val->mahasiswa->alamat : '-' }}</td>
            <td>{{ $val->mahasiswa ? $val->mahasiswa->user->email : '-' }}</td>
            <td>{{ $val->mahasiswa ? $val->mahasiswa->no_hp : '-' }}</td>
            <td>
                {{
                    $val->mahasiswa != null ? (
                        $val->mahasiswa->pendidikanTerakhir != null ? (
                            $val->mahasiswa->pendidikanTerakhir->masterSmaNama != null ? $val->mahasiswa->pendidikanTerakhir->masterSmaNama->nama : '-'
                        ) : '-'
                    ) : '-'
                }}
            </td>
            <td>{{ $val->bayar != null ? "Bayar" : "Belum Bayar"}}</td>
            <td>
                @if(count($val->details) > 0)
                    Lulus
                @else
                    Tidak Lulus
                @endif
            </td>
            @foreach($val->file as $detail)
                <td>
                    <span v-if="detail.text != null">
                    @if($detail->text != null)
                        @if($detail->jenis == 'text')
                            {{ $detail->text }}
                        @else
                            Uploaded
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($detail->status == 0)
                        Waiting
                    @elseif($detail->status == 1)
                        Approved
                    @elseif($detail->status == 2)
                        Failed
                    @else
                        Null
                    @endif
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>