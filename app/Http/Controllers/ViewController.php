<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Interfaces\BreadcrumbInterface;
use Illuminate\View\View;

abstract class ViewController extends Controller implements BreadcrumbInterface
{
    protected function view(string $view, array $data = [], array $mergeData = []): View
    {
        $view = view($view, $data, $mergeData);

        // also append basic view data for base.blade.php here
        $view->with('breadcrumb', $this->getBreadcrumb()->makeReadyForView());;

        return $view;
    }
}
