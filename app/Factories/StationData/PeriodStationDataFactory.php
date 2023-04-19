<?php

namespace App\Factories\StationData;

use Carbon\Carbon as CarbonBase;
use Carbon\CarbonPeriod;

class PeriodStationDataFactory extends StationDataFactory
{
    /**
     * @inheritDoc
     */
    public function getFormat(): string
    {
        return 'yyyy-MM-dd';
    }

    /**
     * @inheritDoc
     */
    public function getInterval(): array
    {
        return ['timeUnit' => "day", 'count' => 1];
    }

    /**
     * @inheritDoc
     */
    protected function getPeriodString(CarbonBase $date): string
    {
        return $date->toDateString();
    }

    /**
     * @inheritDoc
     */
    protected function createPeriodRange(): CarbonPeriod
    {
        return CarbonPeriod::create($this->start, $this->end);
    }
}