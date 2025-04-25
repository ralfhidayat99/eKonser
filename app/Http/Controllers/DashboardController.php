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
            $ongoingConcertCount = Concert::where('date', '<=', now())->where('date', '>=', now()->subHours(3))->count();
            $pastConcertCount = Concert::where('date', '<', now()->subHours(3))->count();

            $ticketSoldCount = Ticket::count();
            $totalRevenue = Ticket::join('ticket_types', 'tickets.ticket_type_id', '=', 'ticket_types.id')
                ->sum('ticket_types.price');

            $registeredUserCount = User::where('role', 'user')->count();
            $recentUserRegistrations = User::where('role', 'user')->orderBy('created_at', 'desc')->take(5)->get();
            $recentTicketPurchases = Ticket::orderBy('created_at', 'desc')->take(5)->get();

            // Alert for low ticket availability (example: less than 10 tickets left for any concert)
            $lowTicketConcerts = Concert::whereHas('tickets', function ($query) {
                $query->havingRaw('count(*) < 10');
            })->get();

            return view('dashboard', compact(
                'upcomingConcertCount',
                'ongoingConcertCount',
                'pastConcertCount',
                'ticketSoldCount',
                'totalRevenue',
                'registeredUserCount',
                'recentUserRegistrations',
                'recentTicketPurchases',
                'lowTicketConcerts'
            ));
        } else {
            return redirect('/');
        }
    }
}
