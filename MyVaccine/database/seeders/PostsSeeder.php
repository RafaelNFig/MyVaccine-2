<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostsSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->delete();

        $posts = [
            ['name' => 'Posto Saúde Central', 'address' => 'Rua Principal, 123', 'city' => 'São Paulo', 'state' => 'SP'],
            ['name' => 'Posto Saúde Campinas', 'address' => 'Rua das Acácias, 258', 'city' => 'Campinas', 'state' => 'SP'],
            ['name' => 'Posto Saúde Ribeirão Preto', 'address' => 'Avenida Independência, 951', 'city' => 'Ribeirão Preto', 'state' => 'SP'],
            ['name' => 'Posto Saúde Joinville', 'address' => 'Rua Blumenau, 369', 'city' => 'Joinville', 'state' => 'SC'],
            ['name' => 'Posto Saúde Norte', 'address' => 'Avenida das Flores, 456', 'city' => 'Rio de Janeiro', 'state' => 'RJ'],
            ['name' => 'Posto Saúde Sul', 'address' => 'Rua das Palmeiras, 789', 'city' => 'Porto Alegre', 'state' => 'RS'],
            ['name' => 'Posto Saúde Leste', 'address' => 'Avenida Central, 321', 'city' => 'Belo Horizonte', 'state' => 'MG'],
            ['name' => 'Posto Saúde Oeste', 'address' => 'Rua das Árvores, 654', 'city' => 'Curitiba', 'state' => 'PR'],
            ['name' => 'Posto Saúde Centro', 'address' => 'Avenida do Sol, 987', 'city' => 'Salvador', 'state' => 'BA'],
            ['name' => 'Posto Saúde Jardins', 'address' => 'Rua das Rosas, 135', 'city' => 'Brasília', 'state' => 'DF'],
            ['name' => 'Posto Saúde Beira-Mar', 'address' => 'Avenida Beira-Mar, 246', 'city' => 'Fortaleza', 'state' => 'CE'],
            ['name' => 'Posto Saúde Praia', 'address' => 'Rua da Praia, 864', 'city' => 'Recife', 'state' => 'PE'],
            ['name' => 'Posto Saúde Montanha', 'address' => 'Avenida das Montanhas, 753', 'city' => 'Manaus', 'state' => 'AM'],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}