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
                            <li class="breadcrumb-item active" aria-current="page">Edit Membership Gym</li>
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
                                <h5 class="mb-0 text-primary">Edit Membership Gym</h5>
                            </div>
                            <hr>
                            <form action="{{ route('admin.membership_gym.update', $membership->id) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                
                                <select class="form-select text-uppercase" id="membership_gym_id" name="membership_gym_id" required>
                                    <option value="" disabled>Pilih Tipe Membership</option>
                                    @foreach ($membershipGyms as $mGym)
                                        <option 
                                            class="text-uppercase" 
                                            value="{{ $mGym->id }}" 
                                            data-durasi="{{ $mGym->durasi }}"
                                            data-harga="{{ $mGym->harga_list }}"
                                            {{ $mGym->id == $membership->membership_gym_id ? 'selected' : '' }}
                                        >
                                            {{ $mGym->nama_list }} - 
                                            @if ($mGym->durasi == 30)
                                                1 Bulan
                                            @elseif ($mGym->durasi == 180)
                                                6 Bulan
                                            @elseif ($mGym->durasi == 360)
                                                12 Bulan
                                            @else
                                                {{ $mGym->durasi }} Hari
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
                                                <option 
                                                    value="{{ $user->id }}" 
                                                    {{ $user->id == $membership->user_id ? 'selected' : '' }}
                                                >
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
                                    <input type="date" class="form-control" id="tanggal_mulai"
                                        value="{{ $membership->tanggal_mulai }}" name="tanggal_mulai" required>
                                </div>
                                <div class="col-12">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                        value="{{ $membership->tanggal_selesai }}" readonly>
                                </div>

                                <div class="col-12">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" id="total_bayar" name="total_bayar" 
                                        value="{{ $membership->total_bayar }}" readonly>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Simpan</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const membershipSelect = document.getElementById('membership_gym_id');
            const durasi = document.getElementById('durasi');
            const totalBayar = document.getElementById('total_bayar');
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');

            // Trigger onchange saat load data
            membershipSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const durasiHari = parseInt(selectedOption.getAttribute('data-durasi'));
                const harga = selectedOption.getAttribute('data-harga');

                // Konversi durasi ke bulan jika lebih dari 29 hari
                if (durasiHari > 29) {
                    const bulan = Math.floor(durasiHari / 30); // Hitung jumlah bulan
                    const sisaHari = durasiHari % 30; // Hitung sisa hari
                    durasi.value = `${bulan} Bulan ${sisaHari > 0 ? sisaHari + ' Hari' : ''}`;
                } else {
                    durasi.value = `${durasiHari} Hari`;
                }

                // Set nilai total bayar
                totalBayar.value = harga;

                // Hitung tanggal selesai berdasarkan tanggal mulai dan durasi
                const tanggalMulaiValue = new Date(tanggalMulai.value);
                const tanggalSelesaiValue = new Date(tanggalMulaiValue);
                tanggalSelesaiValue.setDate(tanggalMulaiValue.getDate() + durasiHari);

                // Format tanggal selesai (YYYY-MM-DD)
                const formattedTanggalSelesai = tanggalSelesaiValue.toISOString().split('T')[0];
                tanggalSelesai.value = formattedTanggalSelesai;
            });

            // Trigger perubahan saat halaman pertama kali dimuat
            membershipSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
