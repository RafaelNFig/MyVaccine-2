<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StocksSeeder extends Seeder
{
    public function run()
    {
        DB::table('stocks')->delete();
        
        $stocks = [
            ['post_id' => 1, 'vaccine_id' => 1, 'quantity' => 100, 'batch' => 'COVID19-001', 'expiration_date' => '2025-12-31'],
            ['post_id' => 1, 'vaccine_id' => 2, 'quantity' => 150, 'batch' => 'GRIPE-002', 'expiration_date' => '2025-11-30'],
            ['post_id' => 2, 'vaccine_id' => 3, 'quantity' => 50, 'batch' => 'SARAMPO-003', 'expiration_date' => '2026-01-15'],
            ['post_id' => 2, 'vaccine_id' => 4, 'quantity' => 200, 'batch' => 'HEPB-004', 'expiration_date' => '2025-10-31'],
            ['post_id' => 3, 'vaccine_id' => 5, 'quantity' => 120, 'batch' => 'POLIO-005', 'expiration_date' => '2026-02-28'],
            ['post_id' => 3, 'vaccine_id' => 6, 'quantity' => 80, 'batch' => 'TETANO-006', 'expiration_date' => '2025-09-30'],
            ['post_id' => 4, 'vaccine_id' => 7, 'quantity' => 60, 'batch' => 'FEBREA-007', 'expiration_date' => '2026-03-15'],
            ['post_id' => 4, 'vaccine_id' => 8, 'quantity' => 90, 'batch' => 'HPV-008', 'expiration_date' => '2025-08-31'],
            ['post_id' => 5, 'vaccine_id' => 9, 'quantity' => 70, 'batch' => 'MENING-009', 'expiration_date' => '2026-04-30'],
            ['post_id' => 5, 'vaccine_id' => 10, 'quantity' => 110, 'batch' => 'RAIVA-010', 'expiration_date' => '2025-07-31'],
            ['post_id' => 6, 'vaccine_id' => 11, 'quantity' => 130, 'batch' => 'ROTAV-011', 'expiration_date' => '2026-05-31'],
            ['post_id' => 6, 'vaccine_id' => 12, 'quantity' => 160, 'batch' => 'VARIC-012', 'expiration_date' => '2025-06-30'],
            ['post_id' => 7, 'vaccine_id' => 13, 'quantity' => 140, 'batch' => 'HIB-013', 'expiration_date' => '2026-06-30'],
            ['post_id' => 8, 'vaccine_id' => 1, 'quantity' => 180, 'batch' => 'COVID19-014', 'expiration_date' => '2025-05-31'],
            ['post_id' => 9, 'vaccine_id' => 2, 'quantity' => 190, 'batch' => 'GRIPE-015', 'expiration_date' => '2026-07-31'],
            ['post_id' => 10, 'vaccine_id' => 3, 'quantity' => 170, 'batch' => 'SARAMPO-016', 'expiration_date' => '2025-04-30'],
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
    }
}