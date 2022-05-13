<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = storage_path('masterdata/prefectures.csv');
        $fp = fopen($file,'r');
        while ($line = fgetcsv($fp)) {
            $data = [];
            $data += $line;
        }

        foreach ($data as $value) {
            DB::table('prefs')->insert([
                'pref' => $value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
