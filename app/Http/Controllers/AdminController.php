<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('admin.dashboard', compact('notifications'));
    }
}
