<?php

use App\User;
use App\Role;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin_role = Role::where('name', 'admin')->first();
        if ($admin_role) {
            User::create([
                'uuid' => Uuid::uuid1()->toString(),
                'name' => 'Administrator',
                'email' => 'admin@pephire.com',
                'password' => bcrypt('secret'),
                'role_id' => $admin_role->id
            ]);
        }

        $user_role = Role::where('name', 'user')->first();
        if ($user_role) {
            User::create([
                'uuid' => Uuid::uuid1()->toString(),
                'name' => 'Test User',
                'email' => 'user@pephire.com',
                'password' => bcrypt('secret'),
                'role_id' => $user_role->id,
                'organization_id' => 1,
                'is_manager' => 1
            ]);
        }

    }
}
