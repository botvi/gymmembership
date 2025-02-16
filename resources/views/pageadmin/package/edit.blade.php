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
                            <li class="breadcrumb-item active" aria-current="page">Membership Package</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--breadcrumb-->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Edit Membership Package</h5>
                            </div>
                            <hr>
                            <form action="{{ route('admin.package.update', $membership->id) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                <select class="form-select text-uppercase" id="package_id" name="package_id" required>
                                    <option value="" disabled>Pilih Package</option>
                                    @foreach ($packages as $package)
                                        <option class="text-uppercase" value="{{ $package->id }}" data-durasi="{{ $package->durasi }}"
                                            data-harga="{{ $package->harga_list }}" data-sesi="{{ $package->sesi }}"
                                            {{ $membership->package_id == $package->id ? 'selected' : '' }}>
                                            {{ $package->sesi }} X -
                                            @if ($package->durasi == 30)
                                                1 Bulan
                                            @elseif ($package->durasi == 180)
                                                6 Bulan
                                            @elseif ($package->durasi == 360)
                                                12 Bulan
                                            @else
                                                {{ $package->durasi }} Hari
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                <div class="col-12">
                                    <label for="user_id" class="form-label">Nama User</label>
                                    <select class="form-select" id="user_id" name="user_id" required>
                                        <option value="" disabled>Pilih User</option>
                                        @foreach ($users as $user)
                                            @if ($user->role === 'user')
                                                <option value="{{ $user->id }}" {{ $membership->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="durasi" class="form-label">Durasi</label>
                                    <input type="text" class="form-control" id="durasi" name="durasi" value="{{ $membership->durasi }}" readonly>
                                </div>

                                <div class="col-12">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                        value="{{ $membership->tanggal_mulai }}" readonly>
                                </div>
                                <div class="col-12">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                        value="{{ $membership->tanggal_selesai }}" readonly>
                                </div>
                                <div class="col-12">
                                    <label for="sesi" class="form-label">Sesi</label>
                                    <input type="number" class="form-control" id="sesi" name="sesi" value="{{ $membership->sesi }}" readonly>
                                </div>

                                <div class="col-12">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" id="total_bayar" name="total_bayar"
                                        value="{{ $membership->total_bayar }}" readonly>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const packageSelect = document.getElementById('package_id');
            const durasiInput = document.getElementById('durasi');
            const totalBayarInput = document.getElementById('total_bayar');
            const tanggalMulaiInput = document.getElementById('tanggal_mulai');
            const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
            const sesiInput = document.getElementById('sesi');

            packageSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const durasiHari = parseInt(selectedOption.getAttribute('data-durasi'));
                const harga = selectedOption.getAttribute('data-harga');
                const sesi = selectedOption.getAttribute('data-sesi');

                // Set durasi
                if (durasiHari > 29) {
                    const bulan = Math.floor(durasiHari / 30);
                    const sisaHari = durasiHari % 30;
                    durasiInput.value = `${bulan} Bulan${sisaHari > 0 ? ` ${sisaHari} Hari` : ''}`;
                } else {
                    durasiInput.value = `${durasiHari} Hari`;
                }

                // Set sesi dan total bayar
                sesiInput.value = sesi;
                totalBayarInput.value = harga;

                // Hitung tanggal selesai
                const tanggalMulai = new Date(tanggalMulaiInput.value);
                const tanggalSelesai = new Date(tanggalMulai);
                tanggalSelesai.setDate(tanggalMulai.getDate() + durasiHari);
                tanggalSelesaiInput.value = tanggalSelesai.toISOString().split('T')[0];
            });
        });
    </script>
@endsection
