<?php

namespace App\Http\Controllers\Analyse;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Interfaces\BreadcrumbInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyseController implements BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('analyse', route('analyse'));
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {


        return view('analyse.index');
    }
}