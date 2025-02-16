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
                            <li class="breadcrumb-item active" aria-current="page">Boxing Muaythai</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Boxing Muaythai</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.boxing_muaythai.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Sesi</th>
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
                                        <td>{{ $p->user->nama }}</td>
                                        <td>{{ $p->sesi }}</td>
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
                                            <a href="{{ route('admin.boxing_muaythai.edit', $p->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.boxing_muaythai.destroy', $p->id) }}"
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
                                    <th>Nama User</th>
                                    <th>Sesi</th>
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
