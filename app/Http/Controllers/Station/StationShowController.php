<?php

namespace App\Http\Controllers\Station;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Contracts\BreadcrumbInterface;
use App\Http\Requests\StationRequest;
use App\Models\Station;
use App\Services\AnalyseMeasurementService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\View as ViewFacade;

class StationShowController extends Controller implements BreadcrumbInterface
{
    public function __construct(
        private readonly AnalyseMeasurementService $service
    ) {
        //
    }

    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Station detail', request()->getRequestUri(), StationIndexController::class);
    }

    /**
     * Display the specified resource.
     *
     * @param Station $station
     * @return Response
     */
    public function show(Station $station)
    {
        Session::put(AnalyseMeasurementService::SELECTION_STATIONS, [$station->name]);

        $factory = $this->service->getFactory();
        $view = ViewFacade::make('station.detail', $this->service->toArray([
            'interval' => $factory->getInterval(),
            'format' => $factory->getFormat(),
            'station' => $station,
            'nearestLocation' => $station->nearestLocation()->first(),
            'geoLocation' => $station->geoLocation()->first(),
        ]));

        if ($this->service->hasSelection()) {
            $view->with('values', $factory->handle()->toJson());
        }

        return $view;
    }

    public function store(StationRequest $request, Station $station)
    {
        $this->service->setSelection($request->validated());

        return Redirect::route('station.show', $station->id);
    }
}
