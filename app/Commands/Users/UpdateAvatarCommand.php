<?php
namespace App\Commands\Users;

use App\Models\User;

class UpdateAvatarCommand
{
    protected User $user;
    protected $avatar;

    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->avatar = $data['avatar'] ?? '';
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
