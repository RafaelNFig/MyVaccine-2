<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Apaga todos os dados da tabela (delete para evitar problemas com foreign keys)
        DB::table('users')->delete();

        // Define o array dos usuários
        $users = [
            ['cpf' => '12345678901', 'role' => 'usuario', 'name' => 'Usuário 1', 'password' => Hash::make('senha1'), 'email' => 'user1@email.com', 'dob' => '1990-01-01', 'address' => 'Endereço 1', 'telephone' => '81999990001'],
            ['cpf' => '98765432109', 'role' => 'usuario', 'name' => 'Usuário 2', 'password' => Hash::make('senha2'), 'email' => 'user2@email.com', 'dob' => '1991-02-02', 'address' => 'Endereço 2', 'telephone' => '81999990002'],
            ['cpf' => '11223344556', 'role' => 'usuario', 'name' => 'Usuário 3', 'password' => Hash::make('senha3'), 'email' => 'user3@email.com', 'dob' => '1992-03-03', 'address' => 'Endereço 3', 'telephone' => '81999990003'],
            ['cpf' => '66554433221', 'role' => 'usuario', 'name' => 'Usuário 4', 'password' => Hash::make('senha4'), 'email' => 'user4@email.com', 'dob' => '1993-04-04', 'address' => 'Endereço 4', 'telephone' => '81999990004'],
            ['cpf' => '12312312312', 'role' => 'usuario', 'name' => 'Usuário 5', 'password' => Hash::make('senha5'), 'email' => 'user5@email.com', 'dob' => '1994-05-05', 'address' => 'Endereço 5', 'telephone' => '81999990005'],
            ['cpf' => '32132132132', 'role' => 'usuario', 'name' => 'Usuário 6', 'password' => Hash::make('senha6'), 'email' => 'user6@email.com', 'dob' => '1995-06-06', 'address' => 'Endereço 6', 'telephone' => '81999990006'],
            ['cpf' => '45645645645', 'role' => 'usuario', 'name' => 'Usuário 7', 'password' => Hash::make('senha7'), 'email' => 'user7@email.com', 'dob' => '1996-07-07', 'address' => 'Endereço 7', 'telephone' => '81999990007'],
            ['cpf' => '65465465465', 'role' => 'usuario', 'name' => 'Usuário 8', 'password' => Hash::make('senha8'), 'email' => 'user8@email.com', 'dob' => '1997-08-08', 'address' => 'Endereço 8', 'telephone' => '81999990008'],
            ['cpf' => '78978978978', 'role' => 'usuario', 'name' => 'Usuário 9', 'password' => Hash::make('senha9'), 'email' => 'user9@email.com', 'dob' => '1998-09-09', 'address' => 'Endereço 9', 'telephone' => '81999990009'],
            ['cpf' => '98798798798', 'role' => 'usuario', 'name' => 'Usuário 10', 'password' => Hash::make('senha10'), 'email' => 'user10@email.com', 'dob' => '1999-10-10', 'address' => 'Endereço 10', 'telephone' => '81999990010'],
            ['cpf' => '15915915915', 'role' => 'usuario', 'name' => 'Usuário 11', 'password' => Hash::make('senha11'), 'email' => 'user11@email.com', 'dob' => '2000-11-11', 'address' => 'Endereço 11', 'telephone' => '81999990011'],
            ['cpf' => '35735735735', 'role' => 'usuario', 'name' => 'Usuário 12', 'password' => Hash::make('senha12'), 'email' => 'user12@email.com', 'dob' => '2001-12-12', 'address' => 'Endereço 12', 'telephone' => '81999990012'],
            ['cpf' => '75375375375', 'role' => 'usuario', 'name' => 'Usuário 13', 'password' => Hash::make('senha13'), 'email' => 'user13@email.com', 'dob' => '2002-01-13', 'address' => 'Endereço 13', 'telephone' => '81999990013'],
            ['cpf' => '99999999999', 'role' => 'admin', 'name' => 'Administrador', 'password' => Hash::make('adm'), 'email' => 'adm@adm.com', 'dob' => '2000-01-01', 'address' => 'n/a', 'telephone' => '81996512724'],
        ];

        // Insere os usuários
        DB::table('users')->insert($users);
    }
}