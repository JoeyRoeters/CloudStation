<?php

namespace App\Factories\StationData;

use Carbon\Carbon as CarbonBase;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class DayStationDataFactory extends StationDataFactory
{
    private const ROUND_TO = 5;

    /**
     * @inheritDoc
     */
    public function getFormat(): string
    {
        return 'HH:mm';
    }

    /**
     * @inheritDoc
     */
    public function getInterval(): array
    {
        return ['timeUnit' => "minute", 'count' => self::ROUND_TO];
    }

    /**
     * @inheritDoc
     */
    protected function getPeriodString(CarbonBase $date): string
    {
        $roundTo = 5;

        return $date->startOfMinute()->subMinutes($date->minute % $roundTo)->toDateTimeString();
    }

    /**
     * @inheritDoc
     */
    protected function createPeriodRange(): CarbonPeriod
    {
        return CarbonPeriod::create($this->start, $this->end->endOfDay())
            ->setDateInterval(CarbonInterval::minutes(self::ROUND_TO));
    }
}