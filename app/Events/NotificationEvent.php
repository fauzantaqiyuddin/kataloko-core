<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent
{
    use Dispatchable, SerializesModels;

    public $user_id;
    public $title;
    public $message;
    public $url;

    public function __construct($user_id, $title, $message, $url)
    {
        $this->user_id = $user_id;  // Bisa null untuk semua user
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }
}
