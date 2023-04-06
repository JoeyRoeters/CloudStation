<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs\Breadcrumb;

class TestParent extends ViewController
{
    public function getBreadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Test parent', 'test', TestParent2::class, 'a');
    }

    public function index()
    {
        return $this->view('base.base');
    }
}
