<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

/**
 * App\Models\Contract
 *
 * @property int $id
 * @property int $company_id
 * @property string $token
 * @property mixed $countries
 * @property mixed $selectables
 * @property string|null $mail_domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereMailDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereSelectables($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'token',
        'countries',
        'selectables',
        'mail_domain'
    ];

    protected $casts = [
        'countries' => 'array',
        'selectables' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function baseQuery(bool $withHistory = false): \Illuminate\Database\Eloquent\Builder
    {
        return Station::query()->with(
            $withHistory ? 'measurements' : 'newest',
            function (HasOne|HasMany $query) {
                $query->select('station_name', ...$this->selectables);
            }
        )->whereHas('geolocation',
            function (Builder $query) {
                $query->whereIn('country_code', $this->countries);
            }
        );
    }
}
