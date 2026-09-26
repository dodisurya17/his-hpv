<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class InformasiHpvSeeder extends Seeder
{
    /**
     * Mengisi deskripsi untuk 3 kartu di section "Informasi HPV" pada landing page.
     * Kontennya bisa diedit kembali kapan saja lewat panel admin (menu Informasi HPV).
     */
    public function run(): void
    {
        $items = [
            [
                'section' => 'informasi',
                'key' => 'definisi_hpv',
                'title' => 'Definisi HPV',
                'order' => 1,
                'description' => 'Human Papillomavirus (HPV) adalah kelompok virus yang menginfeksi kulit dan selaput lendir. Terdapat lebih dari 100 jenis HPV, sebagian bersifat risiko rendah (menyebabkan kutil kulit/kelamin) dan sebagian bersifat risiko tinggi karena dapat memicu perubahan sel yang berujung pada kanker, terutama kanker serviks. HPV menular melalui kontak kulit ke kulit, termasuk hubungan seksual, dan sangat umum terjadi — sebagian besar orang yang aktif secara seksual akan terpapar HPV setidaknya sekali dalam hidupnya.',
            ],
            [
                'section' => 'informasi',
                'key' => 'implikasi_hpv',
                'title' => 'Implikasi HPV',
                'order' => 2,
                'description' => 'Pada banyak kasus, infeksi HPV hilang dengan sendirinya tanpa gejala berarti. Namun, infeksi oleh jenis HPV berisiko tinggi yang menetap dapat menyebabkan perubahan sel abnormal pada leher rahim (serviks), yang jika tidak terdeteksi dan ditangani dapat berkembang menjadi kanker serviks. HPV risiko tinggi juga dikaitkan dengan kanker lain seperti kanker vulva, vagina, penis, anus, dan area kepala-leher. Selain itu, jenis HPV tertentu dapat menyebabkan kutil kelamin (genital warts) yang meski jinak, cukup mengganggu secara fisik maupun psikologis.',
            ],
            [
                'section' => 'informasi',
                'key' => 'pencegahan_hpv',
                'title' => 'Pencegahan HPV',
                'order' => 3,
                'description' => 'Cara paling efektif mencegah infeksi HPV dan dampaknya adalah melalui vaksinasi HPV, idealnya diberikan sejak usia 9-14 tahun sebelum terpapar virus. Selain vaksinasi, pencegahan dapat dilakukan dengan skrining rutin (Pap smear atau tes HPV) untuk deteksi dini perubahan sel pada serviks, praktik hubungan seksual yang aman (termasuk penggunaan kondom, meski tidak memberi perlindungan 100%), serta menjaga kebersihan dan daya tahan tubuh. Deteksi dini dan vaksinasi adalah kombinasi terbaik untuk mencegah kanker akibat HPV.',
            ],
        ];

        foreach ($items as $item) {
            ContentBlock::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
