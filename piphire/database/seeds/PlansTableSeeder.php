<?php

use App\Plan;
use App\Plantype;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $plantype = Plantype::where('id', '1')->first();
        Plan::create([
            'name'              => 'Free Plan',
            'puid'              => Uuid::uuid1()->toString(),
            'amount'            => 0,
            'plantype_id'       => $plantype->id,
            'no_of_searches'    => 3,
            'max_users'         => 1,
            'month_count'       => 3
        ]);        
    }
}
