<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MikrotikBackup;
use Illuminate\Auth\Access\HandlesAuthorization;

class MikrotikBackupPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MikrotikBackup');
    }

    public function view(AuthUser $authUser, MikrotikBackup $mikrotikBackup): bool
    {
        return $authUser->can('View:MikrotikBackup');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MikrotikBackup');
    }

    public function update(AuthUser $authUser, MikrotikBackup $mikrotikBackup): bool
    {
        return $authUser->can('Update:MikrotikBackup');
    }

    public function delete(AuthUser $authUser, MikrotikBackup $mikrotikBackup): bool
    {
        return $authUser->can('Delete:MikrotikBackup');
    }

}