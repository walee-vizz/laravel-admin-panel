<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login_cover()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function login_basic()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }


  public function login(Request $request)
  {
    $validated = $request->validate([
      'email' => ['required'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($validated)) {
      $user = Auth::user();

      return redirect(route('admin.dashboard'));
    } else {
      return redirect()->back()->with('error', 'Email or password incorrect!.');
    }
  }


  public function logout()
  {
    Auth::logout();
    return redirect(route('auth.login'));
  }


  public function register_basic()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function register_cover()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-cover', ['pageConfigs' => $pageConfigs]);
  }
  public function register_multistep()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-multisteps', ['pageConfigs' => $pageConfigs]);
  }

  public function forgot_password_basic()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-forgot-password-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function forgot_password_cover()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-forgot-password-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function reset_password_basic()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-reset-password-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function reset_password_cover()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-reset-password-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function two_steps_basic()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-two-steps-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function two_steps_cover()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-two-steps-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function verify_email_basic()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-verify-email-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function verify_email_cover()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-verify-email-cover', ['pageConfigs' => $pageConfigs]);
  }
}
