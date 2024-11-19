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
                        <li class="breadcrumb-item active" aria-current="page">Membership</li>
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
                <hr/>
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                            <h5 class="mb-0 text-primary">Tambah Membership</h5>
                        </div>
                        <hr>
                        <form action="{{ route('admin.membership.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label for="kategori_membership_id" class="form-label">Nama Kategori</label>
                                    <select class="form-select" id="kategori_membership_id" name="kategori_membership_id" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategoriMemberships as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                          
                            <div class="col-12">
                                <label for="user_id" class="form-label">Nama User</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="" disabled selected>Pilih User</option>
                                    @foreach ($users as $user)
                                        @if($user->role === 'user')
                                            <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="durasi_bulan" class="form-label">Durasi Bulan</label>
                                <select class="form-select" id="durasi_bulan" name="durasi_bulan" required>
                                    <option value="" disabled selected>Pilih Durasi</option>
                                    @foreach ($durasiOptions as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                </select>
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
        // Store kategori prices in JavaScript
        const kategoriPrices = {
            @foreach($kategoriMemberships as $kategori)
                {{ $kategori->id }}: {{ $kategori->harga }},
            @endforeach
        };

        function calculateTotal() {
            const kategoriId = parseInt(document.getElementById('kategori_membership_id').value);
            const durasiBulan = parseInt(document.getElementById('durasi_bulan').value);
            
            if (kategoriId && durasiBulan) {
                const basePrice = kategoriPrices[kategoriId] || 0;
                const total = basePrice * durasiBulan;
                document.getElementById('total_bayar').value = total;
                
                // For debugging
                console.log('Kategori ID:', kategoriId);
                console.log('Base Price:', basePrice);
                console.log('Durasi:', durasiBulan);
                console.log('Total:', total);
            } else {
                document.getElementById('total_bayar').value = '';
            }
        }

        // Add event listeners
        document.getElementById('kategori_membership_id').addEventListener('change', calculateTotal);
        document.getElementById('durasi_bulan').addEventListener('change', calculateTotal);
    });
</script>
@endsection
