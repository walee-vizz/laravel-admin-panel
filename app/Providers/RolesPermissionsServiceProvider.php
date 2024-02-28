<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class RolesPermissionsServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $roles = Role::with('users')->get();
    $permissions = Permission::all();
    $groupedPermissions = [];

    foreach ($permissions as $permission) {
      // Extract the group from the permission name
      $groupName = explode(' ', $permission->name)[1]; // Assuming the group name is the second word

      // Check if the group already exists in the array, if not, create it
      if (!isset($groupedPermissions[$groupName])) {
        $groupedPermissions[$groupName] = [];
      }

      // Add the permission to the group
      $groupedPermissions[$groupName][] = $permission;
    }

    \View::share(['roles' => $roles, 'permissions' => $permissions, 'grouped_permissions' => $groupedPermissions]);
  }
}
