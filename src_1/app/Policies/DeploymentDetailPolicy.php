<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DeploymentDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeploymentDetailPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DeploymentDetail');
    }

    public function view(AuthUser $authUser, DeploymentDetail $deploymentDetail): bool
    {
        return $authUser->can('View:DeploymentDetail');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DeploymentDetail');
    }

    public function update(AuthUser $authUser, DeploymentDetail $deploymentDetail): bool
    {
        return $authUser->can('Update:DeploymentDetail');
    }

    public function delete(AuthUser $authUser, DeploymentDetail $deploymentDetail): bool
    {
        return $authUser->can('Delete:DeploymentDetail');
    }

}