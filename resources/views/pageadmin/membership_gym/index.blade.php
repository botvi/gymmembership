@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Membership Gym</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Membership Gym</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.membership_gym.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tipe Membership</th>
                                    <th>Nama User</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Durasi</th>
                                    <th>Sisa Hari</th>
                                    <th>Total Bayar</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Membership</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memberships as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-uppercase">{{ $p->membershipGym->nama_list }} - @if ($p->durasi == 30)
                                                1 Bulan
                                            @elseif ($p->durasi == 180)
                                                6 Bulan
                                            @elseif ($p->durasi == 360)
                                                12 Bulan
                                            @else
                                                {{ $p->durasi }}
                                            @endif
                                        </td>
                                        <td>{{ $p->user->nama }}</td>
                                        <td>{{ $p->tanggal_mulai }}</td>
                                        <td>{{ $p->tanggal_selesai }}</td>
                                        <td>{{ $p->durasi }}</td>
                                        <td>
                                            @php
                                                $today = \Carbon\Carbon::now();
                                                $endDate = \Carbon\Carbon::parse($p->tanggal_selesai);
                                                $remainingDays = $today->diffInDays($endDate, false);
                                            @endphp
                                            {{ $remainingDays >= 1 ? $remainingDays . ' Hari' : 'Expired' }}
                                        </td>
                                        <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($p->status_pembayaran == 'success')
                                                <span class="badge bg-success">{{ $p->status_pembayaran }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $p->status_pembayaran }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->member_status == 'active')
                                                <span class="badge bg-success">{{ $p->member_status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $p->member_status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.membership_gym.edit', $p->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.membership_gym.destroy', $p->id) }}"
                                                method="POST" style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tipe Membership</th>
                                    <th>Nama User</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Durasi</th>
                                    <th>Sisa Hari</th>
                                    <th>Total Bayar</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Membership</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
