<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\error;

class RoleController extends Controller
{
  public function index()
  {
    // $roles = Role::with('users')->get();
    // $permissions = Permission::with('role')->get();
    // $data = [
    //   'roles' => $roles,
    //   'permissions' => $permissions,
    // ];
    // dd($data);
    return view('content.apps.app-access-roles');
  }

  public function roles_list(Request $request)
  {
    $roles = Role::with('users')->get();

    return response()->json(['data' => $roles]);
  }


  public function store(Request $request)
  {
    $customMessages = [
      'permissions.required' => 'At least one permission must be selected.'
    ];
    $validated = $request->validate([
      'name' =>  ['required', 'string', 'min:3', 'unique:roles,name'],
      'permissions' => 'required|array|min:1', // At least one permission must be selected
      'permissions.*' => 'exists:permissions,id' // Check if each permission ID exists in the database

    ], $customMessages);
    try {
      $data = [
        'name' => $request->name,
      ];

      $role_created = Role::create($data);
      if ($role_created) {
        if ($request->permissions) {
          foreach ($request->permissions as $permissionId) {
            $permission = Permission::find($permissionId);

            // Check if the permission exists
            if ($permission) {
              // Assign the permission to the role
              $role_created->givePermissionTo($permission);
            } else {
              // Handle the case where the permission doesn't exist
            }
          }
        }

        return response()->json(['status' => 'created']);
      }
    } catch (Exception $error) {
      // For example:
      return response()->json(['error' => $error->getMessage()], 500);
    }

    // return response()->json($request->all());
  }


  public function update(Request $request, Role $role)
  {
    $customMessages = [
      'permissions.required' => 'At least one permission must be selected.'
    ];
    $validated = $request->validate([
      'name' =>  ['required', 'string', 'min:3', 'unique:roles,name,' . $role->id . ',id'],
      'permissions' => 'required|array|min:1', // At least one permission must be selected
      'permissions.*' => 'exists:permissions,id' // Check if each permission ID exists in the database

    ], $customMessages);

    try {

      $data = [
        'name' => $request->name
      ];

      $role_updated = Role::find($role->id)->update($data);
      if ($role_updated) {
        $role_updated = Role::find($role->id);
        $role_updated->permissions()->detach();
        if ($request->permissions) {
          foreach ($request->permissions as $permissionId) {
            $permission = Permission::find($permissionId);
            // Check if the permission exists
            if ($permission) {
              // Assign the permission to the role
              $role_updated->givePermissionTo($permission);
            } else {
              // Handle the case where the permission doesn't exist
            }
          }
        }

        return response()->json(['status' => 'Updated']);
      }
    } catch (Exception $error) {
      return response()->json(['error' => $error->getMessage()], 500);
    }
  }


  public function destroy(Role $role)
  {
    try {
      $role->delete();
      return response()->json(['status' => 'Deleted']);
    } catch (Exception $error) {
      return response()->json(['error' => $error->getMessage()], 500);
    }
  }
}
