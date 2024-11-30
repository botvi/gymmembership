<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Detail Transaksi</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Detail Membership</h4>
                        <div class="mb-4">
                            <h5>{{ $kategori_membership->nama }}</h5>
                            <p class="text-muted">Rp {{ number_format($kategori_membership->harga, 0, ',', '.') }}/bulan</p>
                            <div>{!! $kategori_membership->deskripsi !!}</div>
                        </div>

                        <h4 class="mb-3">Detail User</h4>
                        <div class="mb-4">
                            <p><strong>Nama:</strong> {{ $user->nama }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>

                        <form action="{{ route('web.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kategori_membership_id" value="{{ $kategori_membership->id }}">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            
                            <div class="mb-3">
                                <label for="durasi_bulan" class="form-label">Durasi (Bulan)</label>
                                <select class="form-select" id="durasi_bulan" name="durasi_bulan" required>
                                    <option value="1">1 Bulan</option>
                                    <option value="2">2 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="total_bayar_display" class="form-label">Total Bayar</label>
                                <input type="text" class="form-control" id="total_bayar_display" readonly>
                                <input type="hidden" name="total_bayar" id="total_bayar">
                            </div>

                          

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get the base price from the membership
        const basePrice = {{ $kategori_membership->harga }};
        
        // Function to update total payment
        function updateTotalPayment() {
            const durasiBulan = document.getElementById('durasi_bulan').value;
            const totalBayar = basePrice * durasiBulan;
            
            // Set the formatted display value
            const formattedTotal = new Intl.NumberFormat('id-ID').format(totalBayar);
            document.getElementById('total_bayar_display').value = 'Rp ' + formattedTotal;
            
            // Set the actual numeric value for submission
            document.getElementById('total_bayar').value = totalBayar;
        }

        // Add event listener to duration select
        document.getElementById('durasi_bulan').addEventListener('change', updateTotalPayment);
        
        // Calculate initial total on page load
        updateTotalPayment();
    </script>
  </body>
</html>