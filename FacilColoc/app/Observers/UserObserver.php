<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    
    public function created(User $user): void
    {

        if (User::count() === 0) {
            $user->is_global_admin = true;
        }
    }

    
    public function updated(User $user): void
    {

    }

    
    public function deleted(User $user): void
    {

    }

    
    public function restored(User $user): void
    {

    }

    
    public function forceDeleted(User $user): void
    {

    }
}

