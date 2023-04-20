<?php

namespace App\Jobs;

use App\Models\Measurement;
use App\Models\Station;
use App\Models\StationData;
use App\Notifications\NoStationData;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStationData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stations = Station::all();

        $stations->each(function ($station) {
            $latestData = Measurement::where('station_name', $station->name)->latest('created_at')->first();

            if (!$latestData || $latestData->created_at->diffInMinutes(Carbon::now()) > 60) {
                $station->notify(new NoStationData($station->name));
            }
        });
    }
}
