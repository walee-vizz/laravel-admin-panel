<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    return view('content.apps.app-ecommerce-dashboard');
  }

  public function faq()
  {
    return view('content.pages.pages-faq');
  }

  public function pricing()
  {
    return view('content.pages.pages-pricing');
  }
}
