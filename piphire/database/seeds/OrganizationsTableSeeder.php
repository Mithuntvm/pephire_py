<?php

use App\Skill;
use Carbon\Carbon;
use App\Organization;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Organization::create([
            'ouid' => Uuid::uuid1()->toString(),
            'name' => 'Test Organization',
            'email' => 'user@pephire.com',
            'user_id' => 1,
            'plan_id' => 1,
            'total_search' => 3,
            'left_search' => 3,
            'plan_end_date' => Carbon::now()->addMonths(1)->format('Y-m-d')
        ]);

    }
}
