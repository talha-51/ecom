<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $settings;

    public function __construct()
    {
        // Safely load settings
        $this->settings = DB::table('settings')->orderBy('id', 'desc')->first();

        // Share globally with all Blade views
        View::share('settings', $this->settings);
    }
}
