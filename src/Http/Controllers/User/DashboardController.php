<?php

namespace Feadmin\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        seo()->title(__('Panel'));

        return view('feadmin::user.dashboard');
    }
}
