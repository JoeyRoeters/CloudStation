<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

class StationData extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'station_data';

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
        'date' => 'date',
        'time' => 'time',
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
}
