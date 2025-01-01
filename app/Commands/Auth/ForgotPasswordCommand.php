<?php
namespace App\Commands\Auth;

class ForgotPasswordCommand
{
    public $attribute;

    public function __construct(array $data)
    {
        $this->attribute = $data['attribute'] ?? null;
    }
}
