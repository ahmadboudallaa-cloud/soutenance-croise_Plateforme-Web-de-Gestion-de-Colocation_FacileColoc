<?php

namespace App\Services;

use App\Models\User;

class MembershipService
{
    /**
     * Vérifie si l'utilisateur a déjà
     * une colocation active
     */
    public function userHasActiveColocation(User $user): bool
    {
        return $user->colocations()
            ->wherePivot('is_active', true)
            ->exists();
    }
}