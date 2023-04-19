<?php

namespace App\Factories\StationData;

use App\Models\Station;
use App\Models\StationData;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Relations\HasMany;
use MongoDB\BSON\UTCDateTime;

abstract class StationDataFactory
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
    )
    {
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

            $station->data->each(function(StationData $data) use ($periodRange) {
                $period = $periodRange->get($this->getPeriodString($data->created_at));

                if ($period instanceof Collection) {
                    $period->add($data->only($this->fields));
                }
            });

            $periodRange->each(function(Collection $collection, string $date) use ($data) {
                $isNotEmpty = $collection->isNotEmpty();
                $timestamp = Carbon::make($date)->getTimestampMs();

                foreach ($this->fields as $field) {
                    /** @var Collection $series */
                    $series = $data->get($field);

                    $series->add([
                        'date' => $timestamp,
                        'value' => $isNotEmpty ? $collection->average($field) : null
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
            'data' => function(HasMany $query) {
                $query->whereBetween('created_at', [
                    new UTCDateTime($this->start->startOfDay()->getTimestampMs()),
                    new UTCDateTime($this->end->endOfDay()->getTimestampMs()),
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