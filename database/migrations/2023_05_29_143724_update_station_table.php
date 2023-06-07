<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->table('stations', function (Blueprint $collection) {
            $collection->geospatial('location', '2dsphere');
        });

        \App\Models\Station::all()->each(function (\App\Models\Station $station) {
            $station->location = [
                'type' => 'Point',
                'coordinates' => [
                    $station->longitude,
                    $station->latitude,
                ]
            ];
            $station->save();

            $station->unset(['longitude', 'latitude']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
