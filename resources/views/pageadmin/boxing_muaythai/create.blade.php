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
                                <h5 class="mb-0 text-primary">Tambah Boxing Muaythai</h5>
                            </div>
                            <hr>
                            <form action="{{ route('admin.boxing_muaythai.store') }}" method="POST" class="row g-3">
                                @csrf
                                <select class="form-select text-uppercase" id="boxing_muaythai_id" name="boxing_muaythai_id"
                                    required>
                                    <option value="" disabled selected>Pilih Sesi</option>
                                    @foreach ($boxingMuaythais as $boxingMuaythai)
                                        <option class="text-uppercase" value="{{ $boxingMuaythai->id }}"
                                            data-sesi="{{ $boxingMuaythai->sesi }}"
                                            data-harga="{{ $boxingMuaythai->harga_list }}">
                                            {{ $boxingMuaythai->sesi }} X
                                        </option>
                                    @endforeach
                                </select>



                                <div class="col-12">
                                    <label for="user_id" class="form-label">Nama User</label>
                                    <select class="form-select" id="user_id" name="user_id" required>
                                        <option value="" disabled selected>Pilih User</option>
                                        @foreach ($users as $user)
                                            @if ($user->role === 'user')
                                                <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="sesi" class="form-label">Sesi</label>
                                    <input type="text" class="form-control" id="sesi" name="sesi" readonly>
                                </div>


                                <div class="col-12">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" id="total_bayar" name="total_bayar" readonly>
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
            const membershipSelect = document.getElementById('boxing_muaythai_id');
            const sesiInput = document.getElementById('sesi');
            const totalBayarInput = document.getElementById('total_bayar');

            membershipSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                // Ambil data dari atribut
                const sesiValue = selectedOption.getAttribute('data-sesi');
                const hargaValue = selectedOption.getAttribute('data-harga');

                // Set nilai ke input
                sesiInput.value = sesiValue || ''; // Set nilai sesi (kosongkan jika tidak ada)
                totalBayarInput.value = hargaValue || ''; // Set total bayar (kosongkan jika tidak ada)
            });
        });
    </script>
@endsection
