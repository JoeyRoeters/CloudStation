<?php

namespace Database\Seeders;

use App\Models\Measurement;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->subDays(6);
        $period = CarbonPeriod::create(
            $now->clone()->startOfDay(), $now->clone()->addDay()->startOfDay()
        )->setDateInterval(CarbonInterval::minutes(5));
        $dates = $period->toArray();

        Measurement::factory([
            'station_name' => 63770
        ])->state(
            $this->createdAtField($dates)
        )->count($period->count())->create();
    }

    private function createdAtField(array $dates): Sequence
    {
        return new Sequence(fn (Sequence $sequence) => [
            'created_at' => new UTCDateTime($dates[$sequence->index]->getTimestampMs())
        ]);
    }
}
