@extends('layouts.index')
@section('title', 'Dashboard')
@section('content')

<div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat {{ Auth::user()->name }}! 🎉</h5>
                        <p class="mb-4">
                            @if (Auth::user()->role == 'admin')
                        <p class="mb-4">
                            Sebagai admin, Anda telah mengelola <span class="fw-bold">{{ $jumlah_soal }} soal</span> di
                            sistem ini. Pengguna telah menyelesaikan <span class="fw-bold">{{ $countAnswer }}
                                soal</span> dengan
                            skor tertinggi <span class="fw-bold">{{ $nilai_tertinggi }}</span>.
                            Skor pengguna telah meningkat sebesar <span class="fw-bold">{{ $kenaikan_nilai }}</span>.
                        </p>
                        @else
                        <p class="mb-4">
                            Anda telah menyelesaikan <span class="fw-bold">{{ $soal_dikerjakan }} soal</span> sejauh ini
                            dengan
                            skor tertinggi <span class="fw-bold">{{ $nilai_tertinggi }}</span>.<br>
                            Skor Anda telah meningkat sebesar <span class="fw-bold">{{ $kenaikan_nilai }}</span>.
                        </p>
                        @endif
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                            alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
            <!-- Nilai Tertinggi Card -->
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card h-100">
                    <!-- Add h-100 here -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <!-- Ganti dengan ikon yang lebih sesuai -->
                                <i class="bx bx-trophy fs-4 text-warning"></i>
                            </div>
                            <div class="dropdown">
                                <!-- Dropdown button (if needed) -->
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Nilai Tertinggi</span>
                        @if (Auth::user()->role == 'admin')

                        <h3 class="card-title mb-2">{{ $nilaiMax ?? '0' }}</h3>
                        @else

                        <h3 class="card-title mb-2">{{ $nilai_tertinggi ?? '0' }}</h3>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kenaikan Nilai Card -->
            @if(Auth::user()->role == 'user')
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card h-100">
                    <!-- Add h-100 here -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <!-- Ganti dengan ikon yang lebih sesuai -->
                                <i class="bx bx-chart fs-4 text-success"></i>
                            </div>
                        </div>
                        <span>Kenaikan Nilai</span>
                        <h3 class="card-title text-nowrap mb-1">{{ $kenaikan_nilai }}</h3>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>


    <!-- Total Revenue -->
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">History Pengerjaan<span><img
                            src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded mx-2"
                            height="40" /></span></h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @if(Auth::user()->role == 'admin')
                    @foreach($top_users as $user)
                    <li class="d-flex mb-4 pb-1">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block mb-1">Nama: {{ $user->name }}</small>
                                <h6 class="mb-0">Skor Tertinggi: {{ $user->answers->max('score') ?? 'Belum ada skor' }}
                                </h6>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @else
                    @foreach($nilai_per_soal as $nilai)
                    <li class="d-flex mb-4 pb-1">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="text-muted d-block mb-1">Soal: {{ $nilai['question'] }}</small>
                                <h6 class="mb-0">Skor: {{ $nilai['nilai'] }}</h6>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!--/ Total Revenue -->
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card h-100">
                    <!-- Add h-100 here -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-book fs-4 text-info"></i>
                            </div>
                        </div>
                        <span class="d-block mb-1">Jumlah Soal</span>
                        <h3 class="card-title text-nowrap mb-2">{{ $jumlah_soal }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card h-100">
                    <!-- Add h-100 here -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-pencil fs-4 text-primary"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Soal Dikerjakan</span>
                        <h3 class="card-title mb-2">
                            @if(Auth::user()->role == 'admin')
                            {{ $countAnswer }}
                            @else
                            {{ $soal_dikerjakan }}
                            @endif
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <!-- Order Statistics -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">

    </div>
    <!--/ Order Statistics -->

    <!-- Expense Overview -->
    <div class="col-md-6 col-lg-4 order-1 mb-4">

    </div>
    <!--/ Expense Overview -->

    <!-- Transactions -->
    <div class="col-md-6 col-lg-4 order-2 mb-4">

    </div>
    <!--/ Transactions -->
</div>

@endsection