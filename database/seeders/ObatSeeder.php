<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Obat::create([
            'nama_obat' => 'Paracetamol',
            'jenis_obat' => 'Tablet',
            'stock'=> 100,
            'expired'=>  "2023-01-01",
            'harga' => 10000
        ]);
        \App\Models\Obat::create([
            'nama_obat' => 'Aspirin',
            'jenis_obat' => 'Tablet',
            'stock'=> 100,
            'expired'=>  "2023-01-01",
            'harga' => 10000
        ]);
        \App\Models\Obat::create([
            'nama_obat' => 'Ibuprofen',
            'jenis_obat' => 'Tablet',
            'stock'=> 5,
            'expired'=>  "2023-01-01",
            'harga' => 10000
        ]);

    }
}
