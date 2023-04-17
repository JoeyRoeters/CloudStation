<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Models\Station;

class Test extends ViewController
{
    public function getBreadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Edit station', 'test', TestParent::class, 'AAA');
    }

    public function index()
    {
        dd(Station::where('name', 726686)->get());
        return $this->view('base.base');
    }
}
