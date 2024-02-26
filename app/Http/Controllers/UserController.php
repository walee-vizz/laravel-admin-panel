<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    $userCount = $users->count();
    $verified = User::whereNotNull('email_verified_at')->get()->count();
    $notVerified = User::whereNull('email_verified_at')->get()->count();
    $usersUnique = $users->unique(['email']);
    $userDuplicates = $users->diff($usersUnique)->count();

    $data = [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
    ];

    return view('content.laravel-example.user-management', $data);
  }


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
