@extends('layouts.index')
@section('title', 'Kerjakan Ujian')
@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kerjakan Soal: {{ $question->title }}</h5>
        <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('ujian.submit', $question->id) }}" method="POST" id="submitForm">
            @csrf
            <div class="mb-3">
                <p id="content">{!! $question->content !!}</p>
            </div>

            <div class="mb-3">
                <label for="answer" class="form-label">Jawaban Anda</label>
                <textarea id="answer" name="answer" class="form-control" rows="6" required></textarea>
            </div>

            <button type="button" class="btn btn-warning float-end" id="submitBtn">
                Submit Jawaban
            </button>
        </form>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle submit confirmation dengan SweetAlert
    document.getElementById('submitBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pastikan jawaban Anda sudah benar sebelum mengirim.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika ya, submit form
                document.getElementById('submitForm').submit();
            }
        });
    });
</script>
@endpush

@endsection