<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::query()->value('id');

        $answered = [
            [
                'name' => 'Rani Puspita',
                'question' => 'Apakah vaksin HPV aman untuk anak usia SD?',
                'answer' => 'Aman. Vaksin HPV umumnya diberikan mulai usia 9-14 tahun karena di rentang usia ini responsnya paling optimal, dan sudah melalui berbagai uji keamanan.',
            ],
            [
                'name' => 'Budi Santoso',
                'question' => 'Berapa kali suntikan vaksin HPV yang dibutuhkan?',
                'answer' => 'Untuk usia di bawah 15 tahun biasanya cukup 2 dosis dengan jarak 6-12 bulan. Untuk usia 15 tahun ke atas, umumnya 3 dosis.',
            ],
            [
                'name' => 'Sinta Dewi',
                'question' => 'Apakah anak laki-laki juga perlu divaksin HPV?',
                'answer' => 'Perlu. HPV juga bisa menyebabkan masalah kesehatan pada laki-laki, sehingga vaksinasi dianjurkan untuk anak laki-laki maupun perempuan.',
            ],
            [
                'name' => 'Agus Prasetyo',
                'question' => 'Apa efek samping yang paling umum setelah vaksin HPV?',
                'answer' => 'Efek samping yang paling sering adalah nyeri ringan di area suntikan, kemerahan, atau demam ringan yang biasanya hilang dalam 1-2 hari.',
            ],
            [
                'name' => 'Maya Anggraini',
                'question' => 'Apakah vaksin HPV bisa diberikan bersamaan dengan vaksin lain?',
                'answer' => 'Bisa. Vaksin HPV umumnya aman diberikan bersamaan dengan vaksin lain sesuai jadwal imunisasi, atas rekomendasi tenaga kesehatan.',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'question' => 'Kalau sudah pernah kena HPV, apa masih perlu vaksin?',
                'answer' => 'Tetap disarankan. Ada banyak jenis (strain) HPV, sehingga vaksin tetap bisa melindungi dari jenis lain yang belum pernah terpapar.',
            ],
            [
                'name' => 'Wulan Sari',
                'question' => 'Apakah program vaksinasi HPV di sekolah ini gratis?',
                'answer' => 'Untuk info biaya dan jadwal program di sekolah, silakan hubungi kami lewat menu Kontak agar bisa dibantu informasi terbaru.',
            ],
        ];

        $unanswered = [
            [
                'name' => 'Tono Wijaya',
                'question' => 'Apakah ada pantangan makanan setelah vaksin HPV?',
            ],
            [
                'name' => 'Indah Permatasari',
                'question' => 'Apakah vaksin HPV menjamin 100% bebas dari kanker serviks?',
            ],
        ];

        $now = now();

        foreach ($answered as $i => $item) {
            Discussion::create([
                'name' => $item['name'],
                'question' => $item['question'],
                'answer' => $item['answer'],
                'answered_by' => $adminId,
                'answered_at' => $now->copy()->subHours($i * 7),
                'created_at' => $now->copy()->subHours($i * 7 + 2),
                'updated_at' => $now->copy()->subHours($i * 7),
            ]);
        }

        foreach ($unanswered as $i => $item) {
            Discussion::create([
                'name' => $item['name'],
                'question' => $item['question'],
                'answer' => null,
                'created_at' => $now->copy()->subMinutes($i * 30),
                'updated_at' => $now->copy()->subMinutes($i * 30),
            ]);
        }
    }
}
