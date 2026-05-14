<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Deployment;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeploymentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Deployment');
    }

    public function view(AuthUser $authUser, Deployment $deployment): bool
    {
        return $authUser->can('View:Deployment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Deployment');
    }

    public function update(AuthUser $authUser, Deployment $deployment): bool
    {
        return $authUser->can('Update:Deployment');
    }

    public function delete(AuthUser $authUser, Deployment $deployment): bool
    {
        return $authUser->can('Delete:Deployment');
    }

}