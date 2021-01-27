<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Davide',
            'email' => 'janusz79@gmail.com',
            'password' => bcrypt('Pippopluto'),
            'ruolo' => 'Admin',
            'approved'=>true
        ]);
        DB::table('users')->insert([
            'name' => 'Nicola',
            'email' => 'nicola@foxesdesign.it',
            'password' => bcrypt('Nicola1986'),
            'ruolo' => 'Admin',
            'approved'=>true
        ]);
        DB::table('users')->insert([
            'name' => 'Paolo',
            'email' => 'alpacadelfatonero@gmail.com',
            'password' => bcrypt('GrimmAlpaca2018'),
            'ruolo' => 'Admin',
            'approved'=>true
        ]);
       
    }
}
