<?php

namespace Tests\Traits;

use App\Models\User;

/**
 * Help to maintain a single user instance through the test
 */
trait UserTrait
{
    protected User $user;

    /**
     * @return User
     */
    protected function getUser(): User
    {
        if (empty($this->user)) {
            $this->user = User::factory()->create();
        }
        return $this->user;
    }
}
