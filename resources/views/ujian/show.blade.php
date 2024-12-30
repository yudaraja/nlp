@extends('layouts.index')
@section('title', 'Detail Nilai Jawaban')
@section('content')

<div class="container">
    <h4>Detail Nilai Jawaban : {{ $data['question'] }}</h4>

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Detail Jawaban </h4>

            <!-- Soal -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Soal</h5>
                    <p>{{ $data['question'] }}</p>
                </div>
            </div>

            <!-- Kunci Jawaban -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Kunci Jawaban</h5>
                    <p>{{ $data['keyAnswer'] }}</p>
                </div>
            </div>

            <!-- Jawaban -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Jawaban</h5>
                    <p>{{ $data['answer'] }}</p>
                </div>
            </div>

            <!-- Fase Tokenisasi -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Hasil Tokenisasi</h5>
                    <p><strong>Tokenisasi:</strong> Memecah teks menjadi kata-kata individu.</p>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fase</th>
                                    <th>Kata dari Kunci Jawaban</th>
                                    <th>Kata dari Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tokenisasi</td>
                                    <td>
                                        {{ is_array($data['tokensKeyAnswer']) ? implode(', ', $data['tokensKeyAnswer'])
                                        : $data['tokensKeyAnswer'] }}
                                    </td>
                                    <td>
                                        {{ is_array($data['tokensAnswer']) ? implode(', ', $data['tokensAnswer']) :
                                        $data['tokensAnswer'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Fase Stemming -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Hasil Stemming</h5>
                    <p><strong>Stemming:</strong> Mengubah kata ke bentuk dasarnya (stem). Misalnya, "berlari" menjadi
                        "lari".</p>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fase</th>
                                    <th>Stemming Kunci Jawaban</th>
                                    <th>Stemming Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Stemming</td>
                                    <td>{{ $data['stemmedKeyAnswer'] }}</td>
                                    <td>{{ $data['stemmedAnswer'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Fase TF-IDF -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Hasil TF-IDF</h5>
                    <p><strong>TF-IDF:</strong> Mengukur pentingnya kata dalam dokumen relatif terhadap seluruh koleksi
                        dokumen. Semakin sering kata muncul di dokumen tertentu, semakin tinggi nilai TF-IDF-nya.</p>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kata</th>
                                    <th>TF-IDF (Kunci Jawaban)</th>
                                    <th>TF-IDF (Jawaban)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['tfidfValues']['key_answer_tfidf'] as $word => $tfidfValue)
                                <tr>
                                    <td>{{ $word }}</td>
                                    <td>{{ number_format($tfidfValue, 4) }}</td>
                                    <td>{{ number_format($data['tfidfValues']['answer_tfidf'][$word] ?? 0, 4) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cosine Similarity dan Skor -->
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Metode</th>
                                    <th>Hasil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Similarity Score</td>
                                    <td>{{ number_format($data['cosineSimilarity'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Threshold</td>
                                    <td>{{ number_format($data['threshold'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Selisih Score dengan Threshold</td>
                                    <td>{{ number_format($data['cosineSimilarity'] - $data['threshold'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pesan Hasil -->
            @if($data['cosineSimilarity'] >= $data['threshold'])
            <div class="alert alert-success mt-3">
                <strong>Selamat!</strong> Jawaban melampaui atau memenuhi threshold.
            </div>
            @else
            <div class="alert alert-danger mt-3">
                <strong>Gagal!</strong> Jawaban tidak memenuhi threshold.
            </div>
            @endif
        </div>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('ujian.index') }}" class="btn btn-primary mt-3">Kembali</a>
</div>

@endsection