<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\WeatherMeasurementsRequest;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

class WeatherMeasurementsController
{
    public function __invoke(WeatherMeasurementsRequest $request)
    {
        $options = Auth::user()->currentAccessToken()->abilities;

        return Station::query()->with(
            $request->get('history') ? 'measurements' : 'newest',
            function (HasOne|HasMany $query) use ($options) {
                $query->select('station_name', ...$options['selectable']);
            }
        )->whereHas('geolocation',
            function (Builder $query) use ($options) {
                $query->whereIn('country_code', $options['countries']);
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
        ])->select('name')->get();
    }
}