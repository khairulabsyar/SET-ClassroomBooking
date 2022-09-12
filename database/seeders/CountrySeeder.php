<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $json = file_get_contents('database/data/Country.json');

        // laravel path helper function
        $json = file_get_contents(database_path('data/Country.json'));

        // $json = Storage::disk('seed-data')->get('Country.json');

        $data = json_decode($json, true);

        DB::table('countries')->insert($data);
    }
}
