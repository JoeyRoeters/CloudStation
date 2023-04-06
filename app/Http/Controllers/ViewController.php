<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs\Breadcrumb;
use Illuminate\View\View;

abstract class ViewController extends Controller
{
    abstract protected function getBreadcrumb(): Breadcrumb;

    protected function view(string $view, array $data = [], array $mergeData = []): View
    {
        $view = view();

        $view->with('breadcrumb', $this->getBreadcrumb());

        return view($view, $data, $mergeData);
    }
}
