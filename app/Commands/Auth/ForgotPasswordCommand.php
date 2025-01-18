<?php
namespace App\Commands\Auth;

class ForgotPasswordCommand
{
    private string $email;

    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? null;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
