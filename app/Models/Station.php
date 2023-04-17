<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;
use MongoDB\Collection;

class Station extends Model
{
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

    public function geolocations(): HasMany
    {
        return $this->hasMany(Geolocation::class, 'station_name', 'name');
    }

    public function nearestLocations(): HasMany
    {
        return $this->hasMany(NearestLocation::class, 'station_name', 'name');
    }

    public function stationData(): HasMany
    {
        return $this->hasMany(StationData::class, 'station_name', 'name');
    }
}
