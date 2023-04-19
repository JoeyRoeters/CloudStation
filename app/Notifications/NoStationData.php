<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NoStationData extends Notification
{
    protected $station;

    public function __construct($station)
    {
        $this->station = $station;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'station' => $this->station,
        ];
    }
}
