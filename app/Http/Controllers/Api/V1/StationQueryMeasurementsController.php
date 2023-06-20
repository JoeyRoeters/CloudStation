<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Contract as ContractFacade;
use App\Models\Contract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Jenssegers\Mongodb\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class StationQueryMeasurementsController
{
    private readonly Contract $contract;

    public function __construct()
    {
        $this->contract = ContractFacade::getFacadeRoot();
    }

    public function __invoke(int $id)
    {
        return match ($id) {
            1 => $this->stationsBelowZero(),
            2 => $this->stationsOrderByLowestTemperature(),
            default => Response::make('Query not found', ResponseCode::HTTP_NOT_FOUND)
        };
    }

    private function stationsBelowZero()
    {
        return $this->contract->baseQuery()->whereHas('measurements',
            function (Builder $query) {
                $query->where('temperature', '<', 0);
            }
        )->get()->sortBy('newest.temperature');
    }

    private function stationsOrderByLowestTemperature(): Collection
    {
        return $this->contract->baseQuery()->whereHas(
            'measurements'
        )->get()->sortBy('newest.temperature')->splice(0, 10);
    }
}
