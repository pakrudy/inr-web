<?php

namespace App\View\Composers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminNavigationComposer
{
    public function compose(View $view)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $count = Transaction::where('status', 'pending')->count();
            $view->with('pendingTransactionCount', $count);
        }
    }
}
