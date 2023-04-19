<?php

namespace App\Contracts;

use App\Helpers\Breadcrumbs\Breadcrumb;

interface BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb;
}
