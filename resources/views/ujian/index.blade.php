@extends('layouts.index')
@section('title', 'Daftar Ujian')
@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@elseif(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Ujian</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Soal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($questions as $index => $question)
                <tr>
                    <td>{{ $index + 1 + ($questions->currentPage() - 1) * $questions->perPage() }}</td>
                    <td>
                        <a href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $question->id }}">
                            {{ $question->title }}
                        </a>
                    </td>
                    <td>
                        @if($question->userAnswers->isNotEmpty())
                        <span class="badge bg-success">Telah Dikerjakan</span>
                        @else
                        <span class="badge bg-warning">Belum Dikerjakan</span>
                        @endif
                    </td>
                    <td>
                        @if($question->userAnswers->isNotEmpty())
                        <a href="{{ route('ujian.show', $question->id) }}" class="btn btn-success btn-sm">
                            <i class="bx bx-show"></i> <span class="ms-2">Lihat Nilai</span>
                        </a>
                        @else
                        <a href="{{ route('ujian.kerjakan', $question->id) }}" class="btn btn-primary btn-sm">
                            <i class="bx bx-pencil"></i> <span class="ms-2">Kerjakan</span>
                        </a>
                        @endif
                    </td>
                </tr>

                <!-- Modal untuk detail soal -->
                <div class="modal fade" id="detailModal{{ $question->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detail Soal: {{ $question->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Judul Soal:</strong></p>
                                <p style="word-wrap: break-word; white-space: normal;">{{ $question->title }}</p>

                                <p><strong>Isi Soal:</strong></p>
                                <p style="word-wrap: break-word; white-space: normal;">{!! $question->content !!}</p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mx-4 mt-3">
        <div class="demo-inline-spacing">
            <nav aria-label="Page navigation" class="float-end">
                {{ $questions->links('vendor.pagination.custom') }}
            </nav>
        </div>
    </div>
</div>

@endsection