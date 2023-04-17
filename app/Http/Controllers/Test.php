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
        $stations = Station::where('name', 726686)->get();
        foreach ($stations as $station) {
            if ($station->unreadNotifications->count() > 0) {
                dump($station->unreadNotifications);
            }
        }

        die();
        return $this->view('base.base');
    }
}
