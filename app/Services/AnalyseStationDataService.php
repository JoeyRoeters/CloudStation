<?php

namespace App\Services;

use App\Factories\StationData\DayStationDataFactory;
use App\Factories\StationData\PeriodStationDataFactory;
use App\Factories\StationData\StationDataFactory;
use App\Http\Requests\AnalyseRequest;
use App\Models\NearestLocation;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class AnalyseStationDataService
{
    public const SELECTION = 'analyse';
    public const SELECTION_END = 'analyse.end';
    public const SELECTION_START = 'analyse.start';
    public const SELECTION_STATIONS = 'analyse.station_ids';

    public function __construct(
        private readonly Session $session
    ) {
        //
    }

    public function getLabels(): array
    {
        return [
            'temperature' => trans('Temperature'),
            'dew_point_temperature' => trans('Dew Point Temperature'),
            'station_air_pressure' => trans('Station Air Pressure'),
            'sea_level_pressure' => trans('Sea Level Pressure'),
            'visibility' => trans('Visibility'),
            'wind_speed' => trans('Wind Speed'),
            'precipitation' => trans('Precipitation'),
            'snow_depth' => trans('Snow depth'),
            'cloud_cover' => trans('Cloud Cover'),
            'wind_direction' => trans('Wind Direction'),
        ];
    }

    public function getFields(): array
    {
        return array_keys($this->getLabels());
    }

    /**
     * @return Collection|array
     */
    public function getLocations(): Collection|array
    {
        return NearestLocation::with('country')->get([
            'station_name', 'name', 'country_code'
        ])->groupBy(fn(NearestLocation $location) => $location->country->country);
    }

    /**
     * @return StationDataFactory
     */
    public function getFactory(): StationDataFactory
    {
        $arguments = [
            'ids' => $this->getSelectionStations(),
            'start' => $this->getSelectionStartingDate(),
            'end' => $this->getSelectionEndingDate(),
            'fields' => $this->getFields()
        ];

        if ($this->getSelectionStartingDate()->isSameDay($this->getSelectionEndingDate())) {
            return new DayStationDataFactory(...$arguments);
        }

        return new PeriodStationDataFactory(...$arguments);
    }

    /**
     * @return bool
     */
    public function hasSelection(): bool
    {
        return $this->session->has(self::SELECTION);
    }

    /**
     * @param array $request
     *
     * @return void
     */
    public function setSelection(array $data): void
    {
        $this->session->put(self::SELECTION, $data);
    }

    /**
     * @return Carbon
     */
    public function getSelectionEndingDate(): Carbon
    {
        return Carbon::make($this->session->get(self::SELECTION_END, Carbon::now()));
    }

    /**
     * @return Carbon
     */
    public function getSelectionStartingDate(): Carbon
    {
        return Carbon::make($this->session->get(self::SELECTION_START, Carbon::now()->subDays(6)));
    }

    /**
     * @return array
     */
    public function getSelectionStations(): array
    {
        return array_map('intval', $this->session->get(self::SELECTION_STATIONS, []));
    }

    public function toArray(array $data): array
    {
        return [
            ...$data,
            'values' => '{}',
            'labels' => $this->getLabels(),
            'locations' => $this->getLocations(),
            'hasSelection' => $this->hasSelection(),
            'stationIds' => $this->getSelectionStations(),
            'end' => $this->getSelectionEndingDate()->toDateString(),
            'start' => $this->getSelectionStartingDate()->toDateString(),
        ];
    }
}
