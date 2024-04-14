<?php

namespace Database\Seeders;

use App\Models\PaperSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaperSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paperSize = new PaperSize();
        $paperSize->name = 'Custom';
        $paperSize->save();
    }
}
