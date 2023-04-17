<?php

namespace App\Console\Commands;

use App\Models\Station;
use App\Models\StationData;
use App\Notifications\NoStationData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckStationData extends Command
{
    protected $signature = 'check:station-data';

    protected $description = 'Check if there is no new StationData for more than an hour';

    public function handle()
    {
        $stations = Station::all();

        foreach ($stations as $station) {
            $latestData = StationData::where('station_name', $station->name)->latest('created_at')->first();
            if ($station->getUnreadNotifications()->count() > 0) {
                return;
            }

            if (!$latestData || $latestData->created_at->diffInMinutes(Carbon::now()) > 60) {
                $station->notify(new NoStationData($station));
            }
        }
    }
}
