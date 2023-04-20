<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;

class NearestLocation extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'nearest_locations';

    protected $fillable = [
        'name',
        'administrative_region1',
        'administrative_region2',
        'country_code',
        'longitude',
        'latitude'
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
