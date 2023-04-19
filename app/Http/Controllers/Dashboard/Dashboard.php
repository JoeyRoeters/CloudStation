<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TestParent;
use App\Interfaces\BreadcrumbInterface;

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
