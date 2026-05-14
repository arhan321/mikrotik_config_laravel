<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ConfigurationTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigurationTemplatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ConfigurationTemplate');
    }

    public function view(AuthUser $authUser, ConfigurationTemplate $configurationTemplate): bool
    {
        return $authUser->can('View:ConfigurationTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ConfigurationTemplate');
    }

    public function update(AuthUser $authUser, ConfigurationTemplate $configurationTemplate): bool
    {
        return $authUser->can('Update:ConfigurationTemplate');
    }

    public function delete(AuthUser $authUser, ConfigurationTemplate $configurationTemplate): bool
    {
        return $authUser->can('Delete:ConfigurationTemplate');
    }

}