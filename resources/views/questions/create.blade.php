@extends('layouts.index')
@section('title', 'Tambah Soal')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Soal</h5>
        <a href="{{ route('soal.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('soal.store') }}">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul Soal</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Isi Soal</label>
                <textarea class="form-control" id="content" name="content"></textarea>
            </div>
            <div class="mb-3">
                <label for="answer_key" class="form-label">Kunci Jawaban</label>
                <textarea class="form-control" id="answer_key" name="answer_key"></textarea>
            </div>
            <button type="submit" class="btn btn-primary float-end">Simpan Soal</button>
        </form>
    </div>
</div>

@endsection