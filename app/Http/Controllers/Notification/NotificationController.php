<?php

namespace App\Http\Controllers\Notification;

use App\Contracts\BreadcrumbInterface;
use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Helpers\Datatable\Datatable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Notif;
use App\Models\Notification;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Redirect;

class NotificationController extends Controller implements BreadcrumbInterface
{
    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create('Notifications', 'notifications');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('notification.index');
    }

    public function read($name)
    {
        Station::where('name', intval($name))->first()->unreadNotifications[0]->markAsRead();

        return Redirect::route('notification.index');
    }

    public function table(Request $request) {
        $dataTable = new Datatable(['data'], Notification::where('read_at', null));

        return $dataTable->handle($request);
    }
}
