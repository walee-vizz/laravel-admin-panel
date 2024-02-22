<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalbackController extends Controller
{
  public function page_not_found()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.pages.pages-misc-error', ['pageConfigs' => $pageConfigs]);
  }

  public function under_maintenance()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.pages.pages-misc-under-maintenance', ['pageConfigs' => $pageConfigs]);
  }

  public function coming_soon()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.pages.pages-misc-comingsoon', ['pageConfigs' => $pageConfigs]);
  }

  public function un_authorized()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.pages.pages-misc-not-authorized', ['pageConfigs' => $pageConfigs]);
  }
}
