<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vaccine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VaccinesSeeder extends Seeder
{
    public function run()
    {
        DB::table('vaccines')->delete();

        $vaccines = [
            ['name' => 'Vacina contra a COVID-19', 'min_age' => 18, 'max_age' => null, 'contraindications' => 'Alergia grave a componentes da vacina'],
            ['name' => 'Vacina contra a Gripe', 'min_age' => 6, 'max_age' => null, 'contraindications' => 'Alergia a ovo ou componentes da vacina'],
            ['name' => 'Vacina contra o Sarampo', 'min_age' => 12, 'max_age' => 59, 'contraindications' => 'Gravidez, imunossupressão'],
            ['name' => 'Vacina contra a Hepatite B', 'min_age' => 0, 'max_age' => null, 'contraindications' => 'Alergia a levedura'],
            ['name' => 'Vacina contra a Poliomielite', 'min_age' => 2, 'max_age' => null, 'contraindications' => 'Alergia a neomicina ou estreptomicina'],
            ['name' => 'Vacina contra o Tétano', 'min_age' => 7, 'max_age' => null, 'contraindications' => 'Reação alérgica grave a dose anterior'],
            ['name' => 'Vacina contra a Febre Amarela', 'min_age' => 9, 'max_age' => 60, 'contraindications' => 'Alergia a ovo, imunossupressão'],
            ['name' => 'Vacina contra o HPV', 'min_age' => 9, 'max_age' => 26, 'contraindications' => 'Gravidez, alergia a componentes da vacina'],
            ['name' => 'Vacina contra a Meningite', 'min_age' => 2, 'max_age' => 55, 'contraindications' => 'Alergia a componentes da vacina'],
            ['name' => 'Vacina contra a Raiva', 'min_age' => 0, 'max_age' => null, 'contraindications' => 'Alergia a componentes da vacina'],
            ['name' => 'Vacina contra Rotavírus', 'min_age' => 2, 'max_age' => 8, 'contraindications' => 'Intussuscepção prévia'],
            ['name' => 'Vacina contra Varicela', 'min_age' => 12, 'max_age' => null, 'contraindications' => 'Gravidez, imunossupressão'],
            ['name' => 'Vacina contra Haemophilus influenzae tipo b (Hib)', 'min_age' => 2, 'max_age' => 5, 'contraindications' => 'Alergia a componentes da vacina'],
        ];

        foreach ($vaccines as $vaccine) {
            Vaccine::create($vaccine);
        }
    }
}