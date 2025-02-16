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
                            <li class="breadcrumb-item active" aria-current="page">Edit Foreach Time Visit</li>
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
                                <h5 class="mb-0 text-primary">Edit Foreach Time Visit</h5>
                            </div>
                            <hr>
                            <form action="{{ route('admin.per_visit.update', $perVisit->id) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-12">
                                    <label for="foreach_time_visit_id" class="form-label">Tipe Foreach Time Visit</label>
                                    <select class="form-select text-uppercase" id="foreach_time_visit_id" name="foreach_time_visit_id" required>
                                        <option value="" disabled>Pilih Tipe Foreach Time Visit</option>
                                        @foreach ($foreachTimeVisits as $foreachTimeVisit)
                                            <option class="text-uppercase" value="{{ $foreachTimeVisit->id }}" data-harga="{{ $foreachTimeVisit->harga_list }}"
                                                {{ $perVisit->foreach_time_visit_id == $foreachTimeVisit->id ? 'selected' : '' }}>
                                                {{ $foreachTimeVisit->nama_list }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="user_id" class="form-label">Nama User</label>
                                    <select class="form-select" id="user_id" name="user_id" required>
                                        <option value="" disabled>Pilih User</option>
                                        @foreach ($users as $user)
                                            @if ($user->role === 'user')
                                                <option value="{{ $user->id }}" {{ $perVisit->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" id="total_bayar" name="total_bayar" value="{{ $perVisit->total_bayar }}" readonly>
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
            const foreachTimeVisitSelect = document.getElementById('foreach_time_visit_id');
            const totalBayarInput = document.getElementById('total_bayar');

            foreachTimeVisitSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');

                // Set nilai total bayar
                totalBayarInput.value = harga || 0;
            });
        });
    </script>
@endsection
