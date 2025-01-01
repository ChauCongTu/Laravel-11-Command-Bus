<?php
namespace App\Commands\Users;

class CreateUserCommand
{
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $gender;
    public $phone;
    public $prefecture;
    public $city;
    public $address;
    public $etc_address;

    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->prefecture = $data['prefecture'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->etc_address = $data['etc_address'] ?? null;
    }
}
