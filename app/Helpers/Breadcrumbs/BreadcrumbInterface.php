<?php

namespace App\Helpers\Breadcrumbs;

interface BreadcrumbInterface
{
    public function getTitle(): string;

    public function getRoute(): string;

    public function getBreadcrumb(): Breadcrumb;
}
