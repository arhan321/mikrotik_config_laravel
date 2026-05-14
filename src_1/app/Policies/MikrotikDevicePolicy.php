<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MikrotikDevice;
use Illuminate\Auth\Access\HandlesAuthorization;

class MikrotikDevicePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MikrotikDevice');
    }

    public function view(AuthUser $authUser, MikrotikDevice $mikrotikDevice): bool
    {
        return $authUser->can('View:MikrotikDevice');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MikrotikDevice');
    }

    public function update(AuthUser $authUser, MikrotikDevice $mikrotikDevice): bool
    {
        return $authUser->can('Update:MikrotikDevice');
    }

    public function delete(AuthUser $authUser, MikrotikDevice $mikrotikDevice): bool
    {
        return $authUser->can('Delete:MikrotikDevice');
    }

}