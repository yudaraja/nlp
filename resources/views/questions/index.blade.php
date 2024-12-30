@extends('layouts.index')
@section('title', 'Soal Ujian')
@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Soal</h5>
        <a href="{{ route('soal.create') }}" class="btn btn-primary">Tambah Soal</a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Soal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($questions as $index => $question)
                <tr>
                    <td>{{ $index + 1 + ($questions->currentPage() - 1) * $questions->perPage() }}</td>
                    <td>
                        <!-- Menggunakan <a> untuk memicu modal -->
                        <a href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $question->id }}">
                            {{ $question->title }}
                        </a>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('soal.edit', $question->id) }}"><i
                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $question->id }}').submit();"><i
                                        class="bx bx-trash me-1"></i> Delete</a>
                                <form id="delete-form-{{ $question->id }}"
                                    action="{{ route('soal.destroy', $question->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
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

                                <p><strong>Kunci Jawaban:</strong></p>
                                <p
                                    style="word-wrap: break-word; white-space: normal; word-break: break-word; overflow-wrap: break-word;">
                                    {!! $question->answer_key !!}</p>

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