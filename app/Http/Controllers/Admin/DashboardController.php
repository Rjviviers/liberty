<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $username = session('admin_username', 'Admin');
        return view('admin.dashboard', compact('username'));
    }
}
