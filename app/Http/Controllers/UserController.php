<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    return view('content.apps.app-user-list');
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
