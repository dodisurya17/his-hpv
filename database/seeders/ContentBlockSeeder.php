<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class ContentBlockSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['section' => 'profil', 'key' => 'visi', 'title' => 'Visi', 'order' => 1],
            ['section' => 'profil', 'key' => 'misi', 'title' => 'Misi', 'order' => 2],
            ['section' => 'profil', 'key' => 'filosofi_logo', 'title' => 'Filosofi Logo', 'order' => 3],
            ['section' => 'informasi', 'key' => 'definisi_hpv', 'title' => 'Definisi HPV', 'order' => 1],
            ['section' => 'informasi', 'key' => 'implikasi_hpv', 'title' => 'Implikasi HPV', 'order' => 2],
            ['section' => 'informasi', 'key' => 'pencegahan_hpv', 'title' => 'Pencegahan HPV', 'order' => 3],
        ];

        foreach ($items as $item) {
            ContentBlock::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
