<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

/**
 * Menu "Profil" (visi, misi, filosofi_logo) dan "Informasi HPV".
 * Aman dijalankan berulang kali: baris dicocokkan lewat kolom `key`.
 */
class ContentBlockSeeder extends Seeder
{
    public function run(): void
    {
        $blocks = [
            // ---------- Profil ----------
            [
                'section' => 'profil',
                'key' => 'visi',
                'order' => 1,
                'title' => 'Visi',
                'description' => 'Menjadi sumber informasi HPV yang mudah dipahami, terpercaya, dan dekat dengan masyarakat, sehingga setiap anak terlindungi sejak dini.',
            ],
            [
                'section' => 'profil',
                'key' => 'misi',
                'order' => 2,
                'title' => 'Misi',
                'description' => "1. Menyediakan informasi seputar HPV yang akurat dan mudah diakses.\n2. Mendorong orang tua dan sekolah untuk mendukung imunisasi HPV pada anak.\n3. Membuka ruang tanya jawab agar masyarakat berani bertanya dan tidak ragu mencari informasi.",
            ],
            [
                'section' => 'profil',
                'key' => 'filosofi_logo',
                'order' => 3,
                'title' => 'Filosofi Logo',
                'description' => "Perisai biru tua melambangkan perlindungan. Dua anak berseragam sekolah melambangkan generasi yang kita jaga, sedangkan tanda centang dan alat suntik melambangkan imunisasi sebagai langkah pencegahan.\n\nWarna biru menggambarkan kepercayaan, dan aksen merah pada dasi serta pita menggambarkan semangat dan kepedulian.",
            ],

            // ---------- Informasi HPV ----------
            [
                'section' => 'informasi',
                'key' => 'definisi_hpv',
                'order' => 1,
                'title' => 'Definisi HPV',
                'description' => "Human Papillomavirus (HPV) adalah kelompok virus yang menginfeksi kulit dan selaput lendir. Terdapat lebih dari 200 tipe HPV, dan sebagian besar tidak berbahaya.\n\nSekitar belasan tipe di antaranya tergolong berisiko tinggi karena dapat menyebabkan kanker, terutama kanker leher rahim. Tipe lain berisiko rendah dan dapat menyebabkan kutil.",
            ],
            [
                'section' => 'informasi',
                'key' => 'implikasi_hpv',
                'order' => 2,
                'title' => 'Implikasi HPV',
                'description' => "Pada banyak kasus, infeksi HPV hilang dengan sendirinya tanpa gejala berarti. Namun, infeksi oleh jenis HPV berisiko tinggi yang menetap dalam waktu lama dapat berkembang menjadi kanker leher rahim, serta kanker lain seperti kanker anus, vagina, vulva, penis, dan orofaring.\n\nHPV tipe risiko rendah dapat menimbulkan kutil kelamin.",
            ],
            [
                'section' => 'informasi',
                'key' => 'pencegahan_hpv',
                'order' => 3,
                'title' => 'Pencegahan HPV',
                'description' => "Cara paling efektif mencegah infeksi HPV dan dampaknya adalah melalui vaksinasi HPV, idealnya diberikan sejak usia anak sebelum terpapar virus.\n\nDi Indonesia, imunisasi HPV diberikan kepada anak perempuan kelas 5 dan 6 SD/MI melalui program sekolah. Bagi perempuan dewasa, skrining rutin seperti tes IVA atau Pap smear juga penting untuk deteksi dini.",
            ],
            [
                'section' => 'informasi',
                'key' => 'gejala_hpv',
                'order' => 4,
                'title' => 'Gejala HPV',
                'description' => "Sebagian besar infeksi HPV tidak menimbulkan gejala, sehingga sering tidak disadari. Gejala yang mungkin muncul antara lain kutil pada kulit atau area kelamin.\n\nPerubahan sel akibat HPV berisiko tinggi biasanya baru terdeteksi lewat skrining. Karena itu, pemeriksaan rutin dan vaksinasi sangat dianjurkan.",
            ],
        ];

        foreach ($blocks as $block) {
            ContentBlock::updateOrCreate(['key' => $block['key']], $block);
        }
    }
}
