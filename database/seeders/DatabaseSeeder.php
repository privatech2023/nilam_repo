<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\apk_versions;
use App\Models\groups;
use App\Models\User;
use App\Models\user_groups;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@privatech.in',
            'password' => bcrypt('password'),
            'mobile' => '9435173626',
            'gender'   => 'male',
            'user_type' => 'admin',
            'created_by' => 1,
            'status' => 1,
        ]);

        $u_id = $user->id;


        $gdata = [
            'group_name' => 'superadmin',
            'permissions' => 'a:4:{i:0;s:9:"createAll";i:1;s:7:"viewAll";i:2;s:9:"updateAll";i:3;s:9:"deleteAll";}',
        ];
        $group = groups::create($gdata);
        $g_id = $group->id;


        $ugdata = [
            'u_id' => $u_id,
            'g_id' => $g_id,
        ];

        user_groups::create($ugdata);



        $sdata = [
            [
                'key' => 'site_title',
                'value' => 'MY APP',
            ],
            [
                'key' => 'site_footer',
                'value' => 'Copyright © 2023',
            ],
            [
                'key' => 'gst_rate',
                'value' => '18',
            ],
        ];


        DB::table('settings')->insert($sdata);

        apk_versions::create(['version' => 1]);
    }
}
