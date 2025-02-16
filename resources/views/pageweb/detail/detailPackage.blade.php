@extends('template-web.layout')

@section('content')
    <header class="site-header d-flex flex-column justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <h2 class="mb-0">Detail Transaksi</h2>
                </div>
            </div>
        </div>
    </header>

    <section class="latest-podcast-section justify-content-center section-padding pb-0" id="section_2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-12">
                    <form action="{{ route('web.store_package') }}" method="POST">
                        @csrf
                        <div class="custom-block-info mb-5">
                            <h3 class="text-center">Package</h3>
                            <table class="table table-bordered">
                                <tbody>
                                   
                                    <tr>
                                        <th>Durasi</th>
                                        <td>
                                            @if ($listPackage->durasi == 30)
                                                <span class="badge">1 Bulan</span>
                                            @elseif ($listPackage->durasi == 180)
                                                <span class="badge">6 Bulan</span>
                                            @elseif ($listPackage->durasi == 360)
                                                <span class="badge">12 Bulan</span>
                                            @else
                                                <span class="badge">{{ $listPackage->durasi }} Hari</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sesi</th>
                                        <td><span class="badge badge-primary">{{ $listPackage->sesi }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Fasilitas</th>
                                        <td>{{ implode(', ', json_decode($listPackage->fasilitas, true)[0] ?? []) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>Rp. {{ number_format($listPackage->harga_list, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="package_id" value="{{ $listPackage->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="durasi" value="{{ $listPackage->durasi }}">
                        <input type="hidden" name="sesi" value="{{ $listPackage->sesi }}">
                        <input type="hidden" name="total_bayar" value="{{ $listPackage->harga_list }}">

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Lanjutkan Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
