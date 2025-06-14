<?php

namespace App\Services\System;

use App\Mail\SendApproval;
use Illuminate\Support\Facades\Mail;

/**
 * Class ApprovalMailService.
 */
class ApprovalMailService
{
    public function handle($email, $data)
    {
        return Mail::to($email)->send(new SendApproval($data));
    }
}
