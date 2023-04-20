<?php

namespace App\Services;

use App\Models\Measurement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class StoreMeasurementService
{
    protected const FIELDS = [
        'temperature' => 'TEMP',
        'dew_point_temperature' => 'DEWP',
        'station_air_pressure' => 'STP',
        'sea_level_pressure' => 'SLP',
        'visibility' => 'VISIB',
        'wind_speed' => 'WDSP',
        'precipitation' => 'PRCP',
        'snow_depth' => 'SNDP',
        'cloud_cover' => 'CLDC',
        'weather_condition' => 'FRSHTT',
        'wind_direction' => 'WNDDIR',
    ];

    public function resolveAttributes(array $data): array
    {
        $only = $this->getData($data);
        $name = Arr::get($data, 'STN');
        $previous = $this->getPrevious($name);
        $attributes = [
            'station_name' => $name,
        ];

        foreach (self::FIELDS as $field => $key) {
            $value = Arr::get($only, $key);

            $attributes[$field] = match($field) {
                'temperature' => $this->getTemperature($value, $previous),
                'weather_condition' => $this->getLastedValue($value, $previous),
                default => $value ?? round($previous->average($field), 1)
            };
        }

        return $attributes;
    }

    /**
     * @param int $name
     *
     * @return Collection
     */
    protected function getPrevious(int $name): Collection
    {
        return Measurement::whereStationName($name)
            ->latest()->limit(30)->get();
    }

    protected function getData(array $data): array
    {
        return Arr::map(
            Arr::only($data, array_values(self::FIELDS)),
            fn (mixed $value) => $value !== 'None' ? $value : null
        );
    }

    protected function getTemperature(mixed $value, Collection $previous): mixed
    {
        if ($previous->isEmpty()) {
            return $value;
        }

        $average = round($previous->average('temperature'), 1);

        if (is_null($value)) {
            return $average;
        }

        if ($value < (0.8 * $average) || $value > (1.2 * $average)) {
            return  round(0.8 * $value, 1);
        }

        return $value;
    }

    protected function getLastedValue(mixed $value, Collection $previous): mixed
    {
        if (is_null($value) && $previous->isNotEmpty()) {
            return $previous->last()->weather_condition;
        }

        return $value;
    }
}