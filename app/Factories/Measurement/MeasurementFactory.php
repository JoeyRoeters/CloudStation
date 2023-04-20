<?php

namespace App\Factories\Measurement;

use App\Models\Station;
use App\Models\Measurement;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Relations\HasMany;
use MongoDB\BSON\UTCDateTime;

abstract class MeasurementFactory
{
    /**
     * StationDataFactory constructor
     *
     * @param array  $ids
     * @param Carbon $start
     * @param Carbon $end
     * @param array  $fields
     */
    public function __construct(
        protected readonly array  $ids,
        protected readonly Carbon $start,
        protected readonly Carbon $end,
        protected readonly array  $fields,
    ) {
        //
    }

    /**
     * @return Collection
     */
    final public function handle(): Collection
    {
        return $this->query()->get()->mapWithKeys(function(Station $station) {
            $data = $this->resolveDataTemplate();
            $periodRange = $this->resolvePeriodRange();

            $station->measurements->each(function(Measurement $measurement) use ($periodRange) {
                $period = $periodRange->get($this->getPeriodString($measurement->created_at));

                if ($period instanceof Collection) {
                    $period->add($measurement->only($this->fields));
                }
            });

            $periodRange->each(function(Collection $collection, string $date) use ($data) {
                $isNotEmpty = $collection->isNotEmpty();
                $timestamp = Carbon::make($date)->getTimestampMs();

                foreach ($this->fields as $field) {
                    /** @var Collection $measurements */
                    $measurements = $data->get($field);

                    $measurements->add([
                        'date' => $timestamp,
                        'value' => $isNotEmpty ? round($collection->average($field), 1) : null
                    ]);
                }
            });

            return [$station->nearestLocation->name => $data];
        });
    }

    /**
     * @return Builder
     */
    protected function query(): Builder
    {
        return Station::with([
            'measurements' => function(HasMany $query) {
                $query->whereBetween('created_at', [
                    new UTCDateTime($this->resolveStart()->getTimestampMs()),
                    new UTCDateTime($this->resolveEnd()->getTimestampMs()),
                ]);
            },
            'nearestLocation'
        ])->whereIn('name', $this->ids);
    }

    /**
     * @return Collection
     */
    protected function resolvePeriodRange(): Collection
    {
        return Collection::make($this->createPeriodRange())->mapWithKeys(
            fn(Carbon $date) => [$this->getPeriodString($date) => Collection::make()]
        );
    }

    /**
     * @return Collection
     */
    protected function resolveDataTemplate(): Collection
    {
        return Collection::make($this->fields)->mapWithKeys(function(string $field) {
            return [$field => Collection::make()];
        });
    }

    /**
     * @return Carbon
     */
    protected function resolveStart(): Carbon
    {
        return $this->start->clone()->startOfDay();
    }

    /**
     * @return Carbon
     */
    protected function resolveEnd(): Carbon
    {
        return $this->end->clone()->endOfDay();
    }

    /**
     * @return string
     */
    abstract public function getFormat(): string;

    /**
     * @return array
     */
    abstract public function getInterval(): array;

    /**
     * @param Carbon $date
     *
     * @return string
     */
    abstract protected function getPeriodString(Carbon $date): string;

    /**
     * @return CarbonPeriod
     */
    abstract protected function createPeriodRange(): CarbonPeriod;
}