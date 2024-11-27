<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'id_role' => 1,
                'email_verified_at' => NULL,
                'password' => '$2y$10$joDZY50GdWW68I6TPRgNGucK8nc.jqtwCfKxS6HEOgONMEZRSTZ1y',
                'remember_token' => 'AcWncSbj3U0c4mHyjBDiB9Lb9Vm029B0zccMG0POtYgRwmhbqFpXkg6pxj0b',
                'created_at' => '2023-04-03 05:26:11',
                'updated_at' => '2023-06-23 11:51:23',
            ),
        ));
        
        
    }
}