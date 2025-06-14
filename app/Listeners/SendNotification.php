<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use App\Models\System\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendNotification
{
    public function __construct()
    {
        //
    }

    public function handle(NotificationEvent $event)
    {
        // Jika user_id null, notifikasi dikirim ke semua user
        if ($event->user_id) {
            Notification::create([
                'user' => $event->user_id,
                'title' => $event->title,
                'message' => $event->message,
                'url' => $event->url,
            ]);
        } else {
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user' => $user->id,
                    'title' => $event->title,
                    'message' => $event->message,
                    'url' => $event->url,
                ]);
            }
        }
    }
}
