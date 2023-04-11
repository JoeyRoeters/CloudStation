<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;

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

    public function geolocations(): HasMany
    {
        return $this->hasMany(Geolocation::class, 'station_name', 'name');
    }

    public function nearestLocations(): HasMany
    {
        return $this->hasMany(NearestLocation::class, 'station_name', 'name');
    }
}
