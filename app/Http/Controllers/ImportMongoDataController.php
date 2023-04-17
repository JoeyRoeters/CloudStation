<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Geolocation;
use App\Models\NearestLocation;
use App\Models\Station;
use DB;

class ImportMongoDataController extends Controller
{

    /**
     * to import data from mysql to mongodb. First import the sql file in mysql database. Then go to route /import-mongo-data
     * file: mysql_iwa_database_for_mongo_import.sql
     *
     * @return void
     */
    public function index()
    {
        $countries = DB::table('country')->get();

        // Convert countries
        foreach ($countries as $country) {
            // Create a new Country model
            $newCountry = new Country([
                'code' => $country->country_code,
                'country' => $country->country,
            ]);

            $newCountry->save();
        }

        $stations = DB::table('station')->get();

        foreach ($stations as $station) {
            // Create a new Station model
            $newStation = new Station([
                'name' => (int) $station->name,
                'longitude' => $station->longitude,
                'latitude' => $station->latitude,
                'elevation' => $station->elevation
            ]);

            $newStation->save();

            // Convert geolocations for this station
            $geolocations = DB::table('geolocation')
                ->where('station_name', '=', $station->name)
                ->get();

            foreach ($geolocations as $geolocation) {
                // Create a new Geolocation model
                $newGeolocation = new Geolocation([
                    'island' => $geolocation->island,
                    'county' => $geolocation->county,
                    'place' => $geolocation->place,
                    'hamlet' => $geolocation->hamlet,
                    'town' => $geolocation->town,
                    'municipality' => $geolocation->municipality,
                    'state_district' => $geolocation->state_district,
                    'administrative' => $geolocation->administrative,
                    'state' => $geolocation->state,
                    'village' => $geolocation->village,
                    'region' => $geolocation->region,
                    'province' => $geolocation->province,
                    'city' => $geolocation->city,
                    'locality' => $geolocation->locality,
                    'postcode' => $geolocation->postcode
                ]);

                // Assign the foreign key relationships
                $newGeolocation->station()->associate($newStation);
                $newGeolocation->country()->associate(Country::where('code', '=', $geolocation->country_code)->first());

                $newGeolocation->save();
            }

            // Convert nearest locations for this station
            $nearestLocations = DB::table('nearestlocation')
                ->where('station_name', '=', $station->name)
                ->get();

            foreach ($nearestLocations as $nearestLocation) {
                // Create a new NearestLocation model
                $newNearestLocation = new NearestLocation([
                    'name' => $nearestLocation->name,
                    'administrative_region1' => $nearestLocation->administrative_region1,
                    'administrative_region2' => $nearestLocation->administrative_region2,
                    'longitude' => $nearestLocation->longitude,
                    'latitude' => $nearestLocation->latitude
                ]);

                // Assign the foreign key relationships
                $newNearestLocation->station()->associate($newStation);
                $newNearestLocation->country()->associate(Country::where('code', '=', $nearestLocation->country_code)->first());

                $newNearestLocation->save();
            }
        }
    }
}
