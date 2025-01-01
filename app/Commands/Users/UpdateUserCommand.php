<?php
namespace App\Commands\Users;

use App\Models\User;

class UpdateUserCommand
{
    public $user;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $gender;
    public $phone;
    public $bio;
    public $avatar;

    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->bio = $data['bio'] ?? null;
        $this->avatar = $data['avatar'] ?? null;
    }
}
