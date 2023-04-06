<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs\Breadcrumb;

class TestParent2 extends ViewController
{
    public function getBreadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Test 2', 'test');
    }

    public function index()
    {
        return $this->view('base.base');
    }
}
