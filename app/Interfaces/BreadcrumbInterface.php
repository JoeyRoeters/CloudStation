<?php

namespace App\Interfaces;

use App\Helpers\Breadcrumbs\Breadcrumb;

interface BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb;
}
