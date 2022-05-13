<?php

use Illuminate\Database\Seeder;

class PrefOfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = storage_path('masterdata/prefOfficeLocation.csv');
        $fp = fopen($file,'r');
        while ($line = fgetcsv($fp)) {
            $data = [];
            $data += $line;
        }

        foreach ($data as $value) {
            DB::table('pref_Offices')->insert([
                'prefOffice' => $value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
