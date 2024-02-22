<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.landing-page', ['pageConfigs' => $pageConfigs]);
  }

  public function pricing()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.pricing-page', ['pageConfigs' => $pageConfigs]);
  }

  public function payment()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.payment-page', ['pageConfigs' => $pageConfigs]);
  }

  public function checkout()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.checkout-page', ['pageConfigs' => $pageConfigs]);
  }

  public function help_center()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.help-center-landing', ['pageConfigs' => $pageConfigs]);
  }

  public function help_center_article()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.front-pages.help-center-article', ['pageConfigs' => $pageConfigs]);
  }
}
