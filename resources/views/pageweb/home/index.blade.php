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
        <h1>@auth
            {{ Auth::user()->nama }}
        @else
            Guest
        @endauth</h1>
        <h2 class="text-center mb-4">Pilih Kategori Membership</h2>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($kategori_memberships as $kategori)
            <div class="col">
                <a href="{{ route('web.transaksi', $kategori->id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $kategori->nama }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted text-center">Rp {{ number_format($kategori->harga, 0, ',', '.') }}/bulan</h6>
                            <ul class="list-unstyled">
                                {!! $kategori->deskripsi !!}
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tambahkan CSS untuk efek hover -->
    <style>
        .hover-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        }
    </style>

    <!-- Tambahkan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>