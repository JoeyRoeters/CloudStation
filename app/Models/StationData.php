<?php

namespace App\Models;

use App\Exceptions\Stations\StationDataException;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

/**
 * Class StationData
 * @package App\Models
 * @property int $station_name
 * @property string $date
 * @property string $time
 * @property float $tempeture
 * @property float $dew_point_tempeture
 * @property float $station_air_pressure
 * @property float $sea_level_pressure
 * @property float $visibility
 * @property float $wind_speed
 * @property float $precipitation
 * @property float $snow_depth
 * @property string $weather_condition
 * @property float $cloud_cover
 * @property float $wind_direction
 * @property Station $station
 * @property string $created_at
 * @property string $updated_at
 * @property string $_id
 * @method static Builder whereStationName($value)
 * @method static Builder whereDate($value)
 * @method static Builder whereTime($value)
 * @method static Builder whereTempeture($value)
 * @method static Builder whereDewPointTempeture($value)
 * @method static Builder whereStationAirPressure($value)
 * @method static Builder whereSeaLevelPressure($value)
 * @method static Builder whereVisibility($value)
 * @method static Builder whereWindSpeed($value)
 * @method static Builder wherePrecipitation($value)
 * @method static Builder whereSnowDepth($value)
 * @method static Builder whereWeatherCondition($value)
 * @method static Builder whereCloudCover($value)
 * @method static Builder whereWindDirection($value)
 * @method static Builder whereCreatedAt($value)
 * @method static Builder whereUpdatedAt($value)
 * @method static Builder whereId($value)
 */
class StationData extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'station_data';

    public function save(array $options = [])
    {
        $this->handleInconsistentData();

        $fillable = $this->getFillable();
        foreach ($fillable as $field) {
            if ($this->{$field} === null) {
                if (static::getPreviousData($this->station_name)->isEmpty()) {
                    return false;
                }

                throw new StationDataException('Field ' . $field . ' is required');
            }
        }

        return parent::save($options);
    }

    protected $fillable = [
        'station_name',
        'date',
        'time',
        'tempeture',
        'dew_point_tempeture',
        'station_air_pressure',
        'sea_level_pressure',
        'visibility',
        'wind_speed',
        'precipitation',
        'snow_depth',
        'weather_condition',
        'cloud_cover',
        'wind_direction',
    ];

    protected $casts = [
        'station_name' => 'int',
        'date' => 'string',
        'time' => 'string',
        'tempeture' => 'float',
        'dew_point_tempeture' => 'float',
        'station_air_pressure' => 'float',
        'sea_level_pressure' => 'float',
        'visibility' => 'float',
        'wind_speed' => 'float',
        'precipitation' => 'float',
        'snow_depth' => 'float',
        'weather_condition' => 'integer',
        'cloud_cover' => 'float',
        'wind_direction' => 'integer',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'station_name', 'name');
    }

    private static function getPreviousData(int $station, int $limit = 10): Collection
    {
        $data = self::whereStationName($station)
            ->latest()
            ->limit($limit)
            ->get();
        
        return $data;
    }

    public function handleInconsistentData(): void
    {
        $lastData = static::getPreviousData($this->station_name);
        if ($lastData->isEmpty()) {
            return;
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $lastData->first()->date . ' ' . $lastData->first()->time);
        $date->modify('+1 second');
        if ($this->date === null) {
            $this->date = $date->format('Y-m-d');
        }

        if ($this->time === null) {
            $this->time = $date->format('H:i:s');
        }

        // calculate average of last 10 entries
        $calcAvarege = function ($field) use ($lastData) {
            $values = $lastData->pluck($field)->toArray();
            return array_sum($values) / count($values);
        };

        if ($this->tempeture === null) {
            $this->tempeture = $calcAvarege('tempeture');
        }

        if ($this->dew_point_tempeture === null) {
            $this->dew_point_tempeture = $calcAvarege('dew_point_tempeture');
        }

        // calculate average of last 10 station_air_pressures
        if ($this->station_air_pressure === null) {
            $this->station_air_pressure = $calcAvarege('station_air_pressure');
        }

        if ($this->sea_level_pressure === null) {
            $this->sea_level_pressure = $calcAvarege('sea_level_pressure');
        }

        if ($this->visibility === null) {
            $this->visibility = $calcAvarege('visibility');
        }

        if ($this->wind_speed === null) {
            $this->wind_speed = $calcAvarege('wind_speed');
        }

        if ($this->precipitation === null) {
            $this->precipitation = $calcAvarege('precipitation');
        }

        if ($this->snow_depth === null) {
            $this->snow_depth = $calcAvarege('snow_depth');
        }

        if ($this->weather_condition === null) {
            $this->weather_condition = $lastData->first()->weather_condition;
        }

        if ($this->cloud_cover === null) {
            $this->cloud_cover = $calcAvarege('cloud_cover');
        }

        if ($this->wind_direction === null) {
            $this->wind_direction = $calcAvarege('wind_direction');
        }
    }
}
