<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\BreadcrumbInterface;
use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Http\Controllers\TestParent;

class Dashboard implements BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Dashboard', 'dashboard');
    }

    public function dashboard()
    {
        return \View::make('dashboard.dashboard');
    }
}
