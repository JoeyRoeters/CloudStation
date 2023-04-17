<?php

namespace App\Http\Controllers\Analyse;

use App\Helpers\Breadcrumbs\Breadcrumb;
<<<<<<< Updated upstream:app/Http/Controllers/Test.php
use App\Models\Station;
=======
use App\Http\Controllers\ViewController;
use Illuminate\Http\Request;
>>>>>>> Stashed changes:app/Http/Controllers/Analyse/AnalyseController.php

class AnalyseController extends ViewController
{
    public function getBreadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('dawdawd', route('analyse'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
<<<<<<< HEAD:app/Http/Controllers/Test.php
        $stations = Station::where('name', 726686)->get();
        foreach ($stations as $station) {
            if ($station->unreadNotifications->count() > 0) {
                dump($station->unreadNotifications);
            }
        }

        die();
=======
<<<<<<< Updated upstream:app/Http/Controllers/Test.php
        dd(Station::where('name', 726686)->get());
>>>>>>> master:app/Http/Controllers/Analyse/AnalyseController.php
        return $this->view('base.base');
=======
        return $this->view('analyse/index');
>>>>>>> Stashed changes:app/Http/Controllers/Analyse/AnalyseController.php
    }
}