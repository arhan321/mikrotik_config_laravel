<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DeviceVariable;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeviceVariablePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DeviceVariable');
    }

    public function view(AuthUser $authUser, DeviceVariable $deviceVariable): bool
    {
        return $authUser->can('View:DeviceVariable');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DeviceVariable');
    }

    public function update(AuthUser $authUser, DeviceVariable $deviceVariable): bool
    {
        return $authUser->can('Update:DeviceVariable');
    }

    public function delete(AuthUser $authUser, DeviceVariable $deviceVariable): bool
    {
        return $authUser->can('Delete:DeviceVariable');
    }

}