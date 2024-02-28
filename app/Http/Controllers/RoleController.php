<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
}
