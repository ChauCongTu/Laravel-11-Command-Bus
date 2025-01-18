<?php
namespace App\Commands\Auth;

class LoginCommand
{
    private string $email;
    private string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }
}
