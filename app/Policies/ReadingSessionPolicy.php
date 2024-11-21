<?php
// app/Policies/ReadingSessionPolicy.php

namespace App\Policies;

use App\Models\ReadingSession;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReadingSessionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ReadingSession $session)
    {
        return $user->id === $session->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, ReadingSession $session)
    {
        return $user->id === $session->user_id;
    }

    public function delete(User $user, ReadingSession $session)
    {
        return $user->id === $session->user_id;
    }
}