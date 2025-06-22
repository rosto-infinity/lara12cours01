<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function admin():Response
    {
        return Inertia::render('Admin/Users');
    }
    public function superadmin():Response
    {
        return Inertia::render('SuperAdmin/System');
    }
}
