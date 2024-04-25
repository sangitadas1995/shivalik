<?php

namespace Database\Seeders;

use App\Models\PaperunitMeasument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaperunitMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unit = new PaperunitMeasument();
        $unit->measurement_unuit = 'ream';
        $unit->save();
    }
}
