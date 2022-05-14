<?php

use Illuminate\Database\Seeder;

class PrefectureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefsCsv = storage_path('masterdata/prefectures.csv');
        $prefOfficeCsv = storage_path('masterdata/prefOfficeLocation.csv');
        $fp = fopen($prefsCsv,'r');
        while ($line = fgetcsv($fp)) {
            $prefs = [];
            $prefs += $line;
        }

        $fp = fopen($prefOfficeCsv,'r');
        while ($line = fgetcsv($fp)) {
            $prefOffices = [];
            $prefOffices += $line;
        }

        $prefectures = array_combine($prefs,$prefOffices);

        foreach ($prefectures as $pref => $prefOffice) {
            DB::table('prefectures')->insert([
                'pref' => $pref,
                'prefOffice' => $prefOffice,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
