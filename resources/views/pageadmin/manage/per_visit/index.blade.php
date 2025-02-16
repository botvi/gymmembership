@extends('template-admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">FOREACH TIME VISIT</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">MEMBER FOREACH TIME VISIT</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">MEMBER FOREACH TIME VISIT</h6>
            <hr />
            <div class="row mb-4">
                <div class="col-12">
                    <form action="{{ route('admin.manage_per_visit.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="nama" class="form-control me-2" placeholder="Cari nama user" value="{{ request('nama') }}">
                            <input type="text" name="nama_list" class="form-control me-2" placeholder="Cari nama list" value="{{ request('nama_list') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                @foreach ($perVisit as $item)
                    <div class="col">
                        <div class="card radius-15">
                            <div class="card-body text-center">
                                <div class="p-4 border radius-15">
                                    <img src="https://as1.ftcdn.net/v2/jpg/03/46/83/96/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg" width="110" height="110"
                                        class="rounded-circle shadow" alt="">
                                    <h5 class="mb-0 mt-5">{{ $item->user->nama }}</h5>
                                    <p class="mb-3 fw-bold">{{ $item->foreachTimeVisit->nama_list }}</p>
                                    <p class="mb-3"><span class="badge bg-primary">Tanggal Pesan : {{ $item->created_at->format('d-m-Y') }}</span></p>
                                    <p class="mb-3 badge {{ $item->status_kehadiran == 'Hadir' ? 'bg-success' : 'bg-danger' }}">{{ $item->status_kehadiran }}</p>
                                    <div class="d-grid">
                                        @if ($item->status_kehadiran == 'Belum Hadir')
                                            <a href="{{ route('admin.manage_per_visit.update_status_kehadiran', $item->id) }}" class="btn btn-outline-success radius-15">Hadir</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
