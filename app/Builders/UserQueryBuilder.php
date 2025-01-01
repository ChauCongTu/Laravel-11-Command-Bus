<?php
namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function hasMoreThanAddress(int $count): self
    {
        return $this->has('address', '>=', $count);
    }
}
