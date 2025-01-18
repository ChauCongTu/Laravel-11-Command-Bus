<?php
namespace App\Commands\Users;

use App\Models\User;

class UpdateUserCommand
{
    public User $user;
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $gender;
    public string $phone;
    public ?string $bio;
    public ?string $avatar;

    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->email = $data['email'] ?? null;
        $this->firstName = $data['firstName'] ?? null;
        $this->lastName = $data['lastName'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->bio = $data['bio'] ?? null;
        $this->avatar = $data['avatar'] ?? null;
    }
}
