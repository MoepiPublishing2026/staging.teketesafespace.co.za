<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AbuseType;

class SubtypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subtypes')->insert([
            // Bullying Subtypes (abuse_type_id: 1)
            ['abuse_type_id' => 1, 'sub_type_name' => 'Physical Bullying'],
            ['abuse_type_id' => 1, 'sub_type_name' => 'Verbal Bullying'],
            ['abuse_type_id' => 1, 'sub_type_name' => 'Cyberbullying'],
            ['abuse_type_id' => 1, 'sub_type_name' => 'Social Bullying'],
            ['abuse_type_id' => 1, 'sub_type_name' => 'Emotional Bullying'],
            ['abuse_type_id' => 1, 'sub_type_name' => 'Other'],

            // Substance Abuse Subtypes (abuse_type_id: 2)
            ['abuse_type_id' => 2, 'sub_type_name' => 'Alcohol Abuse'],
            ['abuse_type_id' => 2, 'sub_type_name' => 'Drug Abuse'],
            ['abuse_type_id' => 2, 'sub_type_name' => 'Prescription Drug Abuse'],
            ['abuse_type_id' => 2, 'sub_type_name' => 'Other'],

            // Sexual Violence Subtypes (abuse_type_id: 3)
            ['abuse_type_id' => 3, 'sub_type_name' => 'Sexual Assault'],
            ['abuse_type_id' => 3, 'sub_type_name' => 'Sexual Harassment'],
            ['abuse_type_id' => 3, 'sub_type_name' => 'Stalking'],
            ['abuse_type_id' => 3, 'sub_type_name' => 'Other'],

            // Teenage Pregnancy Subtypes (abuse_type_id: 4)
            ['abuse_type_id' => 4, 'sub_type_name' => 'Early Pregnancy'],
            ['abuse_type_id' => 4, 'sub_type_name' => 'Forced Pregnancy'],
            ['abuse_type_id' => 4, 'sub_type_name' => 'Report to parents'],
            ['abuse_type_id' => 4, 'sub_type_name' => 'Report to social worker/Psychologiest'],
            ['abuse_type_id' => 4, 'sub_type_name' => 'Other'],

            // Weapons Subtypes (abuse_type_id: 5)
            ['abuse_type_id' => 5, 'sub_type_name' => 'Knifes'],
            ['abuse_type_id' => 5, 'sub_type_name' => 'Screwdrivers'],
            ['abuse_type_id' => 5, 'sub_type_name' => 'Guns'],
            ['abuse_type_id' => 5, 'sub_type_name' => 'Other'],

            // Violence Subtypes (abuse_type_id: 6)
            ['abuse_type_id' => 6, 'sub_type_name' => 'Domestic Violence'],
            ['abuse_type_id' => 6, 'sub_type_name' => 'Physical Assault'],
            ['abuse_type_id' => 6, 'sub_type_name' => 'Psychological Violence'],
            ['abuse_type_id' => 6, 'sub_type_name' => 'Cultural Violence'],
            ['abuse_type_id' => 6, 'sub_type_name' => 'Other'],
        ]);
    }
}
