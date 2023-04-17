<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;

class Station extends Model
{
    use Notifiable;

    protected $connection = 'mongodb';

    protected $collection = 'stations';

    protected $primaryKey = 'name';

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
