<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

class Geolocation extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'geolocations';

    protected $fillable = [
        'island',
        'country_code',
        'place',
        'hamlet',
        'town',
        'municipality',
        'state_district',
        'administrative',
        'state',
        'village',
        'region',
        'province',
        'city',
        'locality',
        'postcode'
    ];

    protected $hidden = [
        '_id',
        'station_name'
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'station_name', 'name');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}
