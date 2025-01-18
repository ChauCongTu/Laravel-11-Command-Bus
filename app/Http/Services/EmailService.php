<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Password;

class EmailService
{
    public function __construct()
    {}
    public function sendMailReset(string $email)
    {
        try {
            $status = Password::sendResetLink(['email' => $email]);

            if ($status === Password::RESET_LINK_SENT) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
