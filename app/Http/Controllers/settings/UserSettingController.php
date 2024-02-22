<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
  public function account_settings()
  {
    return view('content.pages.pages-account-settings-account');
  }
}
