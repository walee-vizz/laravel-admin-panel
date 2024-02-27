<?php

namespace App\Providers;

use App\Models\Country;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Constraint\Count;
use Spatie\Permission\Models\Role;

class CountryDropdownProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $countries = Country::all();
    $roles = Role::all();
    \View::share('countries_data', $countries);
    \View::share('roles', $roles);
  }
}
