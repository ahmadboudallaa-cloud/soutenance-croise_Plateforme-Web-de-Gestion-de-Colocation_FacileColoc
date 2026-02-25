<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Avant de créer un user (register)
     * Si c'est le 1er user, il devient admin global.
     */
    public function creating(User $user): void
    {
        if (User::count() === 0) {
            $user->is_global_admin = true;
        }
    }
}