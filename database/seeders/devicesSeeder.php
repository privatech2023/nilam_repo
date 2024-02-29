<?php

namespace Database\Seeders;

use App\Models\device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class devicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $duplicates = device::select('device_token', DB::raw('MAX(updated_at) AS max_updated_at'))
            ->groupBy('device_token')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            device::where('device_token', $duplicate->device_token)
                ->where('updated_at', '<', $duplicate->max_updated_at)
                ->delete();
        }
    }
}
