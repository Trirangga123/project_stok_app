<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class stokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

            $Areas = [
                'Palembang' => 'PLG',
                'Bandung'   => 'BDG',
                'Yogyakarta'=> 'DIY',
                'Medan'     => 'MDN',
                'Papua'     => 'PPA',
                'Pekan Baru'=> 'PBRU',
                'Aceh'      => 'ACH',
            ];


        }
    }



