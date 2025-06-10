<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VaccinationHistory;
use Illuminate\Support\Facades\DB;

class VaccinationHistorySeeder extends Seeder
{
    public function run()
    {

        DB::table('vaccination_histories')->delete();

        $histories = [
            ['user_cpf' => '12345678901', 'vaccine_id' => 1, 'post_id' => 1, 'batch' => 'COVID19-001'],
            ['user_cpf' => '98765432109', 'vaccine_id' => 2, 'post_id' => 2, 'batch' => 'GRIPE-002'],
            ['user_cpf' => '11223344556', 'vaccine_id' => 3, 'post_id' => 3, 'batch' => 'SARAMPO-003'],
            ['user_cpf' => '66554433221', 'vaccine_id' => 4, 'post_id' => 4, 'batch' => 'HEPB-004'],
            ['user_cpf' => '12312312312', 'vaccine_id' => 5, 'post_id' => 5, 'batch' => 'POLIO-005'],
            ['user_cpf' => '32132132132', 'vaccine_id' => 6, 'post_id' => 6, 'batch' => 'TETANO-006'],
            ['user_cpf' => '45645645645', 'vaccine_id' => 7, 'post_id' => 7, 'batch' => 'FEBREA-007'],
            ['user_cpf' => '65465465465', 'vaccine_id' => 8, 'post_id' => 8, 'batch' => 'HPV-008'],
            ['user_cpf' => '78978978978', 'vaccine_id' => 9, 'post_id' => 9, 'batch' => 'MENING-009'],
            ['user_cpf' => '98798798798', 'vaccine_id' => 10, 'post_id' => 10, 'batch' => 'RAIVA-010'],
            ['user_cpf' => '15915915915', 'vaccine_id' => 11, 'post_id' => 6, 'batch' => 'ROTAV-011'],
            ['user_cpf' => '35735735735', 'vaccine_id' => 12, 'post_id' => 1, 'batch' => 'VARIC-012'],
            ['user_cpf' => '75375375375', 'vaccine_id' => 13, 'post_id' => 2, 'batch' => 'HIB-013'],
        ];

        foreach ($histories as $history) {
            VaccinationHistory::create($history);
        }
    }
}