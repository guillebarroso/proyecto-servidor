<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;
use Psy\Util\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
    }
}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John',
            'surname' => 'John Doe',
            'age' => 10,
            'email' => 'john@gmail.com',
            'nickname' => 'john',
            'location' => 'cadiz',
            'password' => Hash::make('password'),
            'description' => 'prueba',
            'image' => 'logoSharevolume.png'
        ]);
        DB::table('users')->insert([
            'name' => 'Guillermo',
            'surname' => 'Barroso Canto',
            'age' => 22,
            'email' => 'guille@gmail.com',
            'nickname' => 'guillebarroso',
            'location' => 'cadiz',
            'password' => Hash::make('pestillo'),
            'description' => 'Soy batería y me gustaría poner en alquiler la primera batería con la que aprendí.',
            'image' => 'logoSharevolume.png'
        ]);
        DB::table('users')->insert([
            'name' => 'Javier',
            'surname' => 'Ortega',
            'age' => 10,
            'email' => 'fjortegan@gmail.com',
            'nickname' => 'barbas',
            'location' => 'cadiz',
            'password' => Hash::make('pestillo'),
            'description' => 'No tengo ni idea de tocar la guitarra pero me gustaría aprender',
            'image' => 'logoSharevolume.png'
        ]);

        DB::table('users')->insert([
            'name' => 'John',
            'surname' => 'John Doe',
            'age' => 10,
            'email' => 'john@gmail.com',
            'nickname' => 'john',
            'location' => 'cadiz',
            'password' => Hash::make('password'),
            'description' => 'prueba',
            'image' => 'logoSharevolume.png'
        ]);
        DB::table('users')->insert([
            'name' => 'Guillermo',
            'surname' => 'Barroso Canto',
            'age' => 22,
            'email' => 'guille@gmail.com',
            'nickname' => 'guillebarroso',
            'location' => 'cadiz',
            'password' => Hash::make('pestillo'),
            'description' => 'Soy batería y me gustaría poner en alquiler la primera batería con la que aprendí.',
            'image' => 'logoSharevolume.png'
        ]);
        DB::table('instruments')->insert([
            'user_id' => '1',
            'name' => 'Telecaster Fender John 5 Dorada',
            'type' => 'guitarra',
            'starting_price' => 15,
            'description' => 'barbas',
            'description' => 'guitarra eléctrica última generación',
            'image' => 'guitarra.jpg'
        ]);
    }

}
