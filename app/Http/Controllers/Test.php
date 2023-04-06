<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs\Breadcrumb;

class Test extends ViewController
{
    public function getBreadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Edit station', 'test', TestParent::class, 'AAA');
    }

    public function index()
    {
        return $this->view('base.base');
    }
}
