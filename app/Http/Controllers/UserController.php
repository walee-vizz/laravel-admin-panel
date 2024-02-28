<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function list_view()
  {
    $users = User::all();
    // dd($users);
    $userCount = $users->count();
    $verified = User::whereNotNull('email_verified_at')->get()->count();
    $notVerified = User::whereNull('email_verified_at')->get()->count();
    $usersUnique = $users->unique(['email']);
    $userDuplicates = $users->diff($usersUnique)->count();
    $roles = Role::all();
    $data = [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
      'roles' => $roles
    ];

    return view('content.laravel-example.user-management', $data);
  }

  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'email',
      4 => 'email_verified_at',
    ];

    $search = [];

    $totalData = User::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::with('country')->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::with('country')->where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        if (!empty($user->getRoleNames())) {
          $nestedData['roles'] =  $user->getRoleNames();
        }
        $nestedData['email'] = $user->email;
        $nestedData['email_verified_at'] = $user->email_verified_at;
        $nestedData['country'] = $user->country;

        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
  }

  public function store(Request $request)
  {
    $userID = $request->id;
    $role = [];
    if ($userID) {
      // update the value
      $users = User::updateOrCreate(
        ['id' => $userID],
        [
          'name' => $request->name,
          'email' => $request->email,
          'country_id' => $request?->country_id
        ]
      );
      if (isset($request->roles) && isset($request->roles[0])) {
        $users->roles()->detach();
        foreach ($request->roles as  $role) {
          $role = Role::where('id', $role)->first();
          $users->assignRole($role->name);
        }
      }
      // user updated
      return response()->json(['Updated']);
    } else {
      // create new one if email is unique
      $userEmail = User::where('email', $request->email)->first();

      if (empty($userEmail)) {
        $users = User::updateOrCreate(
          ['id' => $userID],
          [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(Str::random(10)),
            'country_id' => $request->country_id || null
          ],

        );

        // user created
        return response()->json('Created');
      } else {
        // user already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    // $where = ['id' => $id];

    // $users = User::where($where)->first();
    $roleIds = [];
    if (!empty($user->getRoleNames())) {
      $roleNames = $user->getRoleNames();

      $roles = Role::whereIn('name', $roleNames)->get();
      foreach ($roles as $role) {
        $roleIds[] = $role->id;
      }
    }
    $user->role_ids = $roleIds;
    return response()->json($user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $users = User::where('id', $id)->delete();
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function show(User $user)
  {
    return view('content.pages.pages-profile-user');
  }

  public function account()
  {
    return view('content.apps.app-user-view-account');
  }

  public function connections()
  {
    return view('content.pages.pages-profile-connections');
  }

  public function projects()
  {
    return view('content.pages.pages-profile-projects');
  }

  public function teams()
  {
    return view('content.pages.pages-profile-teams');
  }
}
