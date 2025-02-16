@extends('template-web.layout')

@section('content')
    <header class="site-header d-flex flex-column justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <h2 class="mb-0">Package</h2>
                </div>
            </div>
        </div>
    </header>

    <section class="latest-podcast-section justify-content-center section-padding pb-0" id="section_2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-12">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <h5 class="card-title">Detail Transaksi</h5>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Order ID</th>
                                        <td>{{ $transaksi->order_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Durasi</th>
                                        <td>
                                            @if ($transaksi->durasi == 30)
                                                <span class="badge">1 Bulan</span>
                                            @elseif ($transaksi->durasi == 180)
                                                <span class="badge">6 Bulan</span>
                                            @elseif ($transaksi->durasi == 360)
                                                <span class="badge">12 Bulan</span>
                                            @else
                                                <span class="badge">{{ $transaksi->durasi }} Hari</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sesi</th>
                                        <td><span class="badge badge-primary">{{ $transaksi->sesi }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Total Bayar</th>
                                        <td>Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>
                                            <span class="badge {{ $transaksi->status_pembayaran == 'pending' ? 'bg-warning' : ($transaksi->status_pembayaran == 'settlement' || $transaksi->status_pembayaran == 'success' ? 'bg-success' : ($transaksi->status_pembayaran == 'cancel' || $transaksi->status_pembayaran == 'expire' ? 'bg-danger' : 'bg-secondary')) }}">
                                                {{ $transaksi->status_pembayaran }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Mulai</th>
                                        <td>{{ date('d F Y', strtotime($transaksi->tanggal_mulai)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Selesai</th>
                                        <td>{{ date('d F Y', strtotime($transaksi->tanggal_selesai)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

