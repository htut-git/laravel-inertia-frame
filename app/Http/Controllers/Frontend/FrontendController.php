<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function App\Helpers\userHasRole;

class FrontendController extends Controller
{
    function index()
    {
        if (userHasRole('admin') || userHasRole('Super Admin')) {
            return  to_route('admin.dashboard');
        }
        return Inertia::render('Dashboard');
    }
}
