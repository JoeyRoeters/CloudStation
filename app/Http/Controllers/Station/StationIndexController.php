<?php

namespace App\Http\Controllers\Station;

use App\Contracts\BreadcrumbInterface;
use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Helpers\Datatable\Datatable;
use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StationIndexController extends Controller implements BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Stations', 'station');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('station.index');
    }

    public function table(Request $request): JsonResponse
    {
        $dataTable = new Datatable(['_id', 'name', 'longitude', 'latitude'], Station::query());

        return $dataTable->handle($request);
    }
}
