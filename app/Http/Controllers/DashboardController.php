<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Concert;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            $upcomingConcertCount = Concert::where('date', '>=', now())->count();
            $ticketSoldCount = Ticket::count();
            $registeredUserCount = User::where('role', 'user')->count();
            return view('dashboard', compact('upcomingConcertCount', 'ticketSoldCount', 'registeredUserCount'));
        } else {
            return redirect('/');
        }
    }
}
