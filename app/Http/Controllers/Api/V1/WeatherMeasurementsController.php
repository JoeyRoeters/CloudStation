<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Contract;
use App\Http\Requests\Api\V1\WeatherMeasurementsRequest;
use App\Models\Station;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

class WeatherMeasurementsController
{
    public function __invoke(WeatherMeasurementsRequest $request)
    {
        /** @var \App\Models\Contract $contract */
        $contract = Contract::getFacadeRoot();

        return Station::query()->with(
            $request->get('history') ? 'measurements' : 'newest',
            function (HasOne|HasMany $query) use ($contract) {
                $query->select('station_name', ...$contract->selectables);
            }
        )->whereHas('geolocation',
            function (Builder $query) use ($contract) {
                $query->whereIn('country_code', $contract->countries);
            }
        )->where('location', 'near', [
            '$geometry' => [
                'type' => 'Point',
                'coordinates' => [
                    (float) $request->get('longitude'),
                    (float) $request->get('latitude'),
                ],
            ],
            '$maxDistance' => $request->get('distance') * 1000,
        ])->select('name', 'location')->get()->each(function ($station) use ($request) {
            $station->distance = $this->calculateDistance(
                $request->get('latitude'),
                $request->get('longitude'),
                $station['location']['coordinates'][1],
                $station['location']['coordinates'][0]
            );
            unset($station['location']);
        });
    }

    //Magic van het internet, but it works
    private function calculateDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return number_format($angle * $earthRadius, 2);
    }
}
