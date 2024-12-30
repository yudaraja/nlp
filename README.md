# Proyek Sistem Ujian dengan Pengecekan Jawaban Esai Menggunakan NLP

Proyek ini merupakan implementasi sistem ujian online yang menggunakan Natural Language Processing (NLP) untuk memeriksa jawaban esai siswa. Sistem ini mengandalkan teknik-teknik NLP seperti tokenisasi, stemming, dan perhitungan cosine similarity untuk membandingkan jawaban siswa dengan kunci jawaban, serta memberikan skor berdasarkan tingkat kemiripan antara keduanya.

## Fitur Utama

-   **Tokenisasi**: Memecah teks jawaban dan kunci jawaban menjadi kata-kata individu (tokens).
-   **Stemming**: Mengubah kata-kata dalam jawaban dan kunci jawaban ke bentuk dasarnya.
-   **TF-IDF**: Menghitung pentingnya setiap kata dalam konteks jawaban dan kunci jawaban menggunakan nilai TF-IDF.
-   **Cosine Similarity**: Menghitung tingkat kemiripan antara jawaban siswa dan kunci jawaban untuk menilai seberapa relevan jawaban siswa dengan kunci jawaban.
-   **Skor dan Threshold**: Memberikan skor berdasarkan kemiripan dan membandingkannya dengan nilai threshold untuk menentukan apakah jawaban siswa memenuhi kriteria atau tidak.

## Contoh Input dan Output

**Input:**

-   **Soal**: "Siapakah yang memproklamasikan kemerdekaan Indonesia?"
-   **Jawaban Siswa**: "yang memproklamasikan adalah presiden soekarno"

**Output:**

-   **Tokenisasi**:

    -   Kunci Jawaban: "proklamasi, kemerdekaan, indonesia, dibacakan, soekarno, tanggal, 17, agustus, 1945"
    -   Jawaban Siswa: "memproklamasikan, presiden, soekarno"

-   **Stemming**:

    -   Kunci Jawaban: "proklamasi, merdeka, indonesia, baca, soekarno, tanggal, 17, agustus, 1945"
    -   Jawaban Siswa: "proklamasi, presiden, soekarno"

-   **Cosine Similarity**: 0.2521

-   **Skor**: 25 (dengan threshold 80, hasilnya tidak memenuhi threshold)
