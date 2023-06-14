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
        ])->select('name')->get();
    }
}
