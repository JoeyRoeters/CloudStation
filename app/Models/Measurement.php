<?php

namespace App\Models;

use App\Exceptions\Stations\StationDataException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

/**
 * Class StationData
 *
 * @property int $station_name
 * @property string $date
 * @property string $time
 * @property float $temperature
 * @property float $dew_point_temperature
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
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $_id
 *
 * @method static Builder whereStationName($value)
 * @method static Builder whereDate($value)
 * @method static Builder whereTime($value)
 * @method static Builder whereTemperature($value)
 * @method static Builder whereDewPointTemperature($value)
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
class Measurement extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'measurements';

    protected $fillable = [
        'station_name',
        'temperature',
        'dew_point_temperature',
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
        'temperature' => 'float',
        'dew_point_temperature' => 'float',
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
