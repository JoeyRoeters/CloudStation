<?php

namespace App\Factories\Measurement;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class DayMeasurementFactory extends MeasurementFactory
{
    private const PER_MINUTE = 5;

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
        return ['timeUnit' => "minute", 'count' => self::PER_MINUTE];
    }

    /**
     * @inheritDoc
     */
    protected function getPeriodString(Carbon $date): string
    {
        return $date->startOfMinute()->subMinutes($date->minute % self::PER_MINUTE)->toDateTimeString();
    }

    /**
     * @inheritDoc
     */
    protected function createPeriodRange(): CarbonPeriod
    {
        return CarbonPeriod::create($this->resolveStart(), $this->resolveEnd())
            ->setDateInterval(CarbonInterval::minutes(self::PER_MINUTE));
    }

    /**
     * @return Carbon
     */
    protected function resolveEnd(): Carbon
    {
        return $this->end->clone()->addDay()->startOfDay();
    }
}