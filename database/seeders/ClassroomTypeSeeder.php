<?php

namespace Database\Seeders;

use App\Models\ClassroomType;
use Illuminate\Database\Seeder;

class ClassroomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'type' => 'live'],
            ['id' => 2, 'type' => 'recorded'],
            ['id' => 3, 'type' => 'open-study'],
            ['id' => 4, 'type' => 'consultation']
        ];

        //Eloquent ORM
        ClassroomType::insert($data);
    }
}