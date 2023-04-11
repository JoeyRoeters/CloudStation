<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;

class Country extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'countries';

    protected $fillable = [
        'code',
        'country'
    ];

    public function geolocations(): HasMany
    {
        return $this->hasMany(Geolocation::class, 'country_code', 'code');
    }
}
