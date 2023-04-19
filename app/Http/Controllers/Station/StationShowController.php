<?php

namespace App\Http\Controllers\Station;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Contracts\BreadcrumbInterface;
use App\Models\Station;
use Illuminate\Support\Facades\View;

class StationShowController extends Controller implements BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Station detail', request()->getRequestUri(), StationIndexController::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $station = Station::where('_id', $id)->first();

        return View::make('station.detail')->with([
            'station' => $station,
            'nearestLocation' => $station->nearestLocation()->first(),
            'geoLocation' => $station->geoLocation()->first(),
            'data' => $station->data()->get(),
        ]);
    }
}
