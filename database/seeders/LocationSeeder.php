<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Create country Tanzania
        $countryId = DB::table('countries')->insertGetId([
            'name' => 'Tanzania',
            'createby' => 'saysdefaultadmin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Regions list (the user asked Arusha specifically but provided others too)
        $regions = [
            'Arusha',
            'Mwanza',
            'Dar es Salaam',
            'Kilimanjaro',
            'Mbeya',
            'Zanzibar (Unguja)',
            'Dodoma',
            'Tanga',
            'Morogoro',
            'Manyara',
        ];

        $regionIds = [];
        foreach ($regions as $rname) {
            $regionIds[$rname] = DB::table('regions')->insertGetId([
                'countryid' => $countryId,
                'name' => $rname,
                'createdby' => 'saysdefaultadmin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $districts = [
            'Arusha' => [
                'Arusha City','Arusha Rural','Karatu','Longido','Meru','Monduli','Ngorongoro'
            ],
            'Mwanza' => [
                'Buchosa','Ilemela','Kwimba','Magu','Misungwi','Nyamagana','Sengerema','Ukerewe'
            ],
            'Dar es Salaam' => [
                'Ilala','Kigamboni','Kinondoni','Temeke','Ubungo'
            ],
            'Kilimanjaro' => [
                'Hai','Moshi Rural','Moshi Municipal','Mwanga','Rombo','Same','Siha'
            ],
            'Mbeya' => [
                'Busokelo','Chunya','Kyela','Mbarali','Mbeya (Rural)','Mbeya City / Urban','Rungwe'
            ],
        ];

        foreach ($districts as $regionName => $districtList) {
            if (!isset($regionIds[$regionName])) {
                continue; // skip if region wasn't created
            }
            foreach ($districtList as $dname) {
                DB::table('districts')->insert([
                    'regionid' => $regionIds[$regionName],
                    'name' => $dname,
                    'createdby' => 'saysdefaultadmin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
