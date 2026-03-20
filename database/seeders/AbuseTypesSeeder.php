<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AbuseType;

class AbuseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abuseTypes = [
            'Bullying',
            'Substance Abuse',
            'Sexual Abuse',
            'Teenage Pregnancy',
            'Weapons',
            'Violence',
        ];

        foreach ($abuseTypes as $type) {
            AbuseType::firstOrCreate(['type_name' => $type]);
        }
    }
}
