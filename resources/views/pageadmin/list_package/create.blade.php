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
                            <li class="breadcrumb-item active" aria-current="page">Package</li>
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
                                <h5 class="mb-0 text-primary">Tambah Package</h5>
                            </div>
                            <hr>
                            <form action="{{ route('listpackage.store') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-12">
                                    <label for="durasi" class="form-label">Durasi (Hari)</label>
                                    <input type="text" class="form-control" id="durasi" name="durasi" required>
                                </div>
                                <div class="col-12">
                                    <label for="sesi" class="form-label">Sesi X</label>
                                    <input type="number" class="form-control" id="sesi" name="sesi" required>
                                </div>
                                <div class="col-12">
                                    <label for="harga_list" class="form-label">Harga</label>
                                    <input type="text" class="form-control" id="harga_list" name="harga_list" required>
                                </div>
                            
                                <div id="opsiContainer">
                                    <div id="opsiList" class="opsi-item">
                                        <!-- Dynamic fields start here -->
                                        <div class="col-12">
                                            <label for="fasilitas" class="form-label">Fasilitas</label>
                                            <input type="text" class="form-control" name="fasilitas[0]" required>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-warning mt-3" onclick="addSubopsi(this)"><i class='bx bx-list-plus'></i></button>
                                        <button type="button" class="btn btn-sm btn-danger mt-3" onclick="removeOpsi(this)"><i class='bx bxs-trash'></i></button>
                                        <!-- Dynamic fields end here -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" required></textarea>
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
        const opsiList = document.getElementById('opsiList');
        const clone = opsiList.cloneNode(true);
        const newIndex = opsiContainer.querySelectorAll('.opsi-item').length;
        clone.querySelectorAll('input').forEach(input => {
            const baseName = input.name.split('[')[0];
            input.name = `${baseName}[${newIndex}]`;
            input.value = '';
        });
        opsiContainer.appendChild(clone);
    }

    function removeOpsi(button) {
        const opsiContainer = document.getElementById('opsiContainer');
        const opsiList = button.parentElement;
        if (opsiContainer.children.length > 1) {
            opsiContainer.removeChild(opsiList);
        }
    }
</script>
@endsection