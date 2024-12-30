<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id = 1;

        $questions = [
            [
                'title' => 'Biologi pada tubuh manusia',
                'content' => 'Apa yang terjadi pada tubuh manusia ketika luka?',
                'answer_key' => 'Sel darah putih akan mendekati dan menutupi luka untuk melawan infeksi, sementara platelet akan membentuk bekuan darah untuk menghentikan perdarahan.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Sejarah Indonesia',
                'content' => 'Siapakah yang memproklamasikan kemerdekaan Indonesia?',
                'answer_key' => 'Proklamasi kemerdekaan Indonesia dibacakan oleh Soekarno pada tanggal 17 Agustus 1945.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Geografi dunia',
                'content' => 'Apa nama benua terbesar di dunia?',
                'answer_key' => 'Benua terbesar di dunia adalah Asia.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Kimia dalam kehidupan',
                'content' => 'Apa yang terjadi ketika air mendidih?',
                'answer_key' => 'Ketika air mendidih, molekul-molekul air bergerak lebih cepat, menghasilkan uap dan perubahan fase dari cair menjadi gas.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Fisika dasar',
                'content' => 'Apa yang dimaksud dengan hukum Newton tentang gerak pertama?',
                'answer_key' => 'Hukum Newton pertama menyatakan bahwa sebuah benda akan tetap diam atau bergerak lurus beraturan jika tidak ada gaya yang bekerja padanya.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Ekonomi Makro',
                'content' => 'Apa yang dimaksud dengan inflasi?',
                'answer_key' => 'Inflasi adalah kenaikan harga barang dan jasa secara umum dalam suatu periode waktu yang menyebabkan daya beli masyarakat berkurang.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Sejarah Dunia',
                'content' => 'Apa yang menyebabkan Perang Dunia I pecah?',
                'answer_key' => 'Perang Dunia I dipicu oleh pembunuhan Archduke Franz Ferdinand dari Austria, yang memicu persaingan antar negara besar di Eropa.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Biologi manusia',
                'content' => 'Apa yang dimaksud dengan sistem pencernaan manusia?',
                'answer_key' => 'Sistem pencernaan manusia terdiri dari saluran pencernaan yang mengolah makanan untuk diserap nutrisinya dan membuang limbah.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Matematika dasar',
                'content' => 'Bagaimana cara menghitung luas lingkaran?',
                'answer_key' => 'Luas lingkaran dapat dihitung dengan rumus πr², di mana r adalah jari-jari lingkaran.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Sejarah Indonesia',
                'content' => 'Siapa yang menjadi Presiden pertama Indonesia?',
                'answer_key' => 'Presiden pertama Indonesia adalah Soekarno, yang juga merupakan tokoh proklamator kemerdekaan.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Kimia dasar',
                'content' => 'Apa yang dimaksud dengan reaksi redoks?',
                'answer_key' => 'Reaksi redoks adalah reaksi kimia yang melibatkan transfer elektron antara dua zat, di mana satu zat teroksidasi dan zat lainnya tereduksi.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Geografi dunia',
                'content' => 'Apa yang dimaksud dengan garis ekuator?',
                'answer_key' => 'Garis ekuator adalah garis imajiner yang membagi Bumi menjadi dua belahan, yaitu belahan utara dan selatan.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Sejarah dunia',
                'content' => 'Apa yang terjadi pada tahun 1945 di dunia?',
                'answer_key' => 'Pada tahun 1945, Perang Dunia II berakhir dengan kemenangan Sekutu, dan PBB dibentuk untuk menjaga perdamaian dunia.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Biologi tumbuhan',
                'content' => 'Apa yang dimaksud dengan fotosintesis?',
                'answer_key' => 'Fotosintesis adalah proses yang dilakukan oleh tumbuhan untuk mengubah energi matahari menjadi energi kimia dalam bentuk glukosa.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Fisika dasar',
                'content' => 'Apa yang dimaksud dengan gaya gravitasi?',
                'answer_key' => 'Gaya gravitasi adalah gaya tarik menarik yang dimiliki oleh setiap benda terhadap benda lainnya, terutama yang terjadi antara Bumi dan objek di sekitarnya.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Matematika terapan',
                'content' => 'Bagaimana cara menghitung volume bola?',
                'answer_key' => 'Volume bola dihitung dengan rumus 4/3πr³, di mana r adalah jari-jari bola.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Kimia dalam kehidupan sehari-hari',
                'content' => 'Apa yang dimaksud dengan larutan asam dan basa?',
                'answer_key' => 'Larutan asam adalah larutan yang memiliki pH kurang dari 7, sementara larutan basa memiliki pH lebih dari 7.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Sejarah Indonesia',
                'content' => 'Kapan Indonesia merdeka?',
                'answer_key' => 'Indonesia merdeka pada tanggal 17 Agustus 1945 setelah proklamasi kemerdekaan yang dibacakan oleh Soekarno dan Hatta.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Biologi hewan',
                'content' => 'Apa yang dimaksud dengan sistem peredaran darah pada manusia?',
                'answer_key' => 'Sistem peredaran darah manusia terdiri dari jantung, pembuluh darah, dan darah yang mengalir untuk mengangkut oksigen dan nutrisi ke seluruh tubuh.',
                'created_by' => $user_id
            ],
            [
                'title' => 'Geografi Indonesia',
                'content' => 'Apa ibu kota dari Indonesia?',
                'answer_key' => 'Ibu kota Indonesia adalah Jakarta, yang terletak di Pulau Jawa.',
                'created_by' => $user_id
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
