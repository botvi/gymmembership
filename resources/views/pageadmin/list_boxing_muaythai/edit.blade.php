@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Forms</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Boxing dan Muaythai</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <div class="row">
                <div class="col-xl-7 mx-auto">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-edit me-1 font-22 text-primary"></i></div>
                                <h5 class="mb-0 text-primary">Edit Boxing dan Muaythai</h5>
                            </div>
                            <hr>
                            <form action="{{ route('listboxingmuaythai.update', $membership->id) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-12">
                                    <label for="sesi" class="form-label">X Sesi</label>
                                    <input type="text" class="form-control" id="sesi" name="sesi" value="{{ $membership->sesi }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="harga_list" class="form-label">Harga</label>
                                    <input type="text" class="form-control" id="harga_list" name="harga_list" value="{{ $membership->harga_list }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea  rows="5" type="text" class="form-control" id="deskripsi" name="deskripsi" required>{{ $membership->deskripsi }}</textarea>
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