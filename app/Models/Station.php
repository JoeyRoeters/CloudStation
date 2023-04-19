<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

/**
 * @property Collection $data
 * @property NearestLocation $nearestLocation
 */
class Station extends Model
{
    use Notifiable;

    protected $connection = 'mongodb';

    protected $collection = 'stations';

    protected $fillable = [
        'name',
        'longitude',
        'latitude',
        'elevation'
    ];

    protected $casts = [
        'name' => 'int',
        'longitude' => 'float',
        'latitude' => 'float',
        'elevation' => 'float',
    ];

    /**
     * @return HasMany
     */
    public function data(): HasMany
    {
        return $this->hasMany(StationData::class, 'station_name', 'name');
    }

    /**
     * @return HasOne
     */
    public function geolocation(): HasOne
    {
        return $this->hasOne(Geolocation::class, 'station_name', 'name');
    }

    /**
     * @return HasOne
     */
    public function nearestLocation(): HasOne
    {
        return $this->hasOne(NearestLocation::class, 'station_name', 'name');
    }
}
