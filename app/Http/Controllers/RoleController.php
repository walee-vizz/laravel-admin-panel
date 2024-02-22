<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
  public function index()
  {
    return view('content.apps.app-access-roles');
  }
}
