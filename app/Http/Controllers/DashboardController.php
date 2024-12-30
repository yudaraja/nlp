<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        // Ambil data soal yang telah dijawab oleh pengguna
        $questions = Question::with([
            'userAnswers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Statistik
        $jumlah_soal = Question::count(); // Total soal

        $soal = Question::with([
            'userAnswers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        $soal_dikerjakan = $soal->filter(function ($question) {
            return $question->userAnswers->isNotEmpty(); // Soal yang dikerjakan
        })->count();

        $total_user_score = $this->sumAllUserScores();

        // Nilai tertinggi (score) dari semua jawaban yang dikerjakan
        $nilai_tertinggi = $questions->flatMap(function ($question) {
            return $question->userAnswers->pluck('score');
        })->max();

        // Kenaikan nilai (misalnya berdasarkan perbandingan dengan sebelumnya)
        $nilai_sebelumnya = UserAnswer::where('user_id', $user->id)
            ->whereHas('question', function ($query) {
                $query->where('created_at', '<', now()->subMonth());
            })
            ->max('score');

        $kenaikan_nilai = $nilai_tertinggi - $nilai_sebelumnya;

        // Ambil nilai dari setiap soal yang telah dikerjakan
        $nilai_per_soal = $questions->map(function ($question) {
            return [
                'question' => $question->title,
                'nilai' => $question->userAnswers->pluck('score')->first() ?? 0,
            ];
        });

        // Ambil top 5 users dengan score tertinggi, kecuali role admin, urutkan berdasarkan score ascending
        $top_users = User::where('role', '!=', 'admin')
            ->withMax('answers as max_score', 'score')
            ->orderBy('max_score', 'asc')
            ->take(5)
            ->get();

        $countAnswer = UserAnswer::count();
        $nilaiMax = UserAnswer::max('score');

        // Kirim data ke view
        return view('dashboard', compact('nilaiMax', 'countAnswer', 'jumlah_soal', 'soal_dikerjakan', 'nilai_tertinggi', 'kenaikan_nilai', 'nilai_per_soal', 'top_users', 'total_user_score'));
    }

    private function sumAllUserScores()
    {
        return UserAnswer::sum('score');
    }
}
