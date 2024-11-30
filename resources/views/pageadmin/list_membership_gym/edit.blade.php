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
                            <li class="breadcrumb-item active" aria-current="page">Edit Membership Gym</li>
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
                                <h5 class="mb-0 text-primary">Edit Membership Gym</h5>
                            </div>
                            <hr>
                            <form action="{{ route('listmembershipgym.update', $membership->id) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="col-12">
                                    <label for="nama_list" class="form-label">Nama List</label>
                                    <select class="form-select" id="nama_list" name="nama_list" required>
                                        <option value="monthly" {{ $membership->nama_list == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="visit" {{ $membership->nama_list == 'visit' ? 'selected' : '' }}>Visit</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="harga_list" class="form-label">Harga</label>
                                    <input type="text" class="form-control" id="harga_list" name="harga_list" value="{{ $membership->harga_list }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="durasi" class="form-label">Durasi (Hari)</label>
                                    <input type="text" class="form-control" id="durasi" name="durasi" value="{{ $membership->durasi }}" required>
                                </div>

                                <div id="opsiContainer">
                                    @foreach ($fasilitas as $index => $name)
                                        <div id="opsiList" class="opsi-item">
                                            <div class="col-12">
                                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                                <input type="text" class="form-control" name="fasilitas[{{ $index }}]" value="{{ $name }}" required>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-warning mt-3" onclick="addSubopsi(this)"><i class='bx bx-list-plus'></i></button>
                                            <button type="button" class="btn btn-sm btn-danger mt-3" onclick="removeOpsi(this)"><i class='bx bxs-trash'></i></button>
                                        </div>
                                    @endforeach
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
    function addSubopsi(button) {
        const opsiContainer = document.getElementById('opsiContainer');
        const newIndex = opsiContainer.querySelectorAll('.opsi-item').length;

        const newItem = `
            <div class="opsi-item">
                <div class="col-12">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <input type="text" class="form-control" name="fasilitas[${newIndex}]" required>
                </div>
                <button type="button" class="btn btn-sm btn-warning mt-3" onclick="addSubopsi(this)"><i class='bx bx-list-plus'></i></button>
                <button type="button" class="btn btn-sm btn-danger mt-3" onclick="removeOpsi(this)"><i class='bx bxs-trash'></i></button>
            </div>
        `;

        opsiContainer.insertAdjacentHTML('beforeend', newItem);
    }

    function removeOpsi(button) {
        const opsiContainer = document.getElementById('opsiContainer');
        const opsiItem = button.closest('.opsi-item');
        if (opsiContainer.children.length > 1) {
            opsiContainer.removeChild(opsiItem);
        }
    }
</script>
@endsection
