<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Selesaikan Pembayaran</h2>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body">    
                            <h5 class="card-title">Nama Kategori</h5>
                            <p class="card-text">Durasi : {{ $transaksi->durasi_bulan }} Bulan</p>
                            <p class="card-text">Total Bayar : Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                            <p class="card-text">Status : {{ $transaksi->status }}</p>
                            <p class="card-text">Tanggal Mulai : {{ $transaksi->tanggal_mulai }}</p>
                            <p class="card-text">Tanggal Selesai : {{ $transaksi->tanggal_selesai }}</p>
                            <button id="pay-button">Pay!</button>
                            <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> 
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $transaksi->snap_token }}', {
          // Optional
          onSuccess: function(result){
            window.location.href = "{{ route('web.success', $transaksi->order_id) }}";
          },
          // Optional
          onPending: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onError: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };
    </script>
</html>