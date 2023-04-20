<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\BreadcrumbInterface;
use App\Helpers\Breadcrumbs\Breadcrumb;

class DashboardController implements BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Dashboard', route('dashboard'));
    }

    public function index()
    {
        return \View::make('dashboard.dashboard');
    }
}
