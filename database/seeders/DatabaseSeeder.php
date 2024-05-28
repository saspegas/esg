<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $topicTitles = [
            'Politika',
            'Riskler',
            'Yönetim Programları',
            'Organizasyon',
            'Acil Durum',
            'Paydaş Katılımı',
            'Şikayetler',
            'Raporlama',
            'İzleme',
        ];

        foreach ($topicTitles as $title) {
            Topic::factory(['name' => $title])->has(
                Question::factory()->count(3)->has(
                    Choice::factory()->count(4)
                )
            )->create();
        }
    }
}
