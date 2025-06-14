<?php

namespace App\Services\System;

use App\Mail\SendInviteMail;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendInviteMailService.
 */
class SendInviteMailService
{
    public function handle($params, $email)
    {
        return Mail::to($email)->send(new SendInviteMail($params));
    }
}
