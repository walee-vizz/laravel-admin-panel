<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $roles = [
      'super admin',
      'user',
      'moderator'
    ];

    $permissions = [
      'view roles',
      'create roles',
      'edit roles',
      'delete roles',
      'view permissions',
      'create permissions',
      'edit permissions',
      'delete permissions',
      'view users',
      'create users',
      'edit users',
      'delete users',
      'edit profile',
    ];

    foreach ($permissions as $permission) {
      if (!Permission::where('name', $permission)->exists()) {
        // Create the permission only if it doesn't exist
        $permission_created = Permission::create(["name" => $permission]);
      }
    }

    foreach ($roles as $role) {
      $role_created = Role::create(["name" => $role]);

      if ($role == 'user') {
        $role_created->givePermissionTo('edit profile');
      } else {
        $role_created->givePermissionTo(Permission::all());
      }
    }

    $user = [
      'name' => 'super admin',
      'email' => 'admin@gmail.com',
      'password' => Hash::make('password')
    ];

    $userCreated = User::create($user);
    $userCreated->assignRole('super admin');
  }
}
