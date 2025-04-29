<?php

namespace Database\Seeders;

use App\Repositories\StationRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $stations = json_decode(file_get_contents(asset('json/station.json')));
        $stations = json_decode(file_get_contents(public_path('json/station.json')));

        foreach ($stations as $station) {
           (new StationRepository()) -> create([
                'slug' => Str::slug($station->title) . '-' . Str::random(6),
                'title' => $station->title,
                'description' => $station->description,
                'latitude'=> $station->latitude,
                'longitude' => $station->longitude,
           ]);
        }
    }
}
