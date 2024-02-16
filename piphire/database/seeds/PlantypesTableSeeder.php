<?php

use App\Plantype;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;

class PlantypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Plantype::create([
            'name'              => 'Prepaid Plan',
            'tuid'              => Uuid::uuid1()->toString()
        ]);
    }
}
