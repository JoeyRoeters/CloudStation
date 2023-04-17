<?php

namespace App\Http\Controllers\Station;

use App\Exceptions\Stations\StationDataApiException;
use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\StationData;
use Illuminate\Http\Request;

class StationDataController extends Controller
{
    public function store(Request $request)
    {
        $weatherData = $request->input('WEATHERDATA', []);

        foreach ($weatherData as $data) {
            if (Station::where('name', (int) $data['STN'])->doesntExist()) {
                throw new StationDataApiException('Station does not exist');
            }

            $data = array_map(function ($value) {
                return $value === 'None' ? null : $value;
            }, $data);

            $stationData = new StationData([
                'station_name' => $data['STN'],
                'date' => $data['DATE'],
                'time' => $data['TIME'],
                'tempeture' => $data['TEMP'],
                'dew_point_tempeture' => $data['DEWP'],
                'station_air_pressure' => $data['STP'],
                'sea_level_pressure' => $data['SLP'],
                'visibility' => $data['VISIB'],
                'wind_speed' => $data['WDSP'],
                'precipitation' => $data['PRCP'],
                'snow_depth' => $data['SNDP'],
                'weather_condition' => $data['FRSHTT'],
                'cloud_cover' => $data['CLDC'],
                'wind_direction' => $data['WNDDIR'],
            ]);

            $stationData->handleInconsistentData();

            $stationData->save();
        }

        return response()->json(['message' => 'Weather data stored successfully']);
    }
}
