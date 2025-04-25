<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;

class TicketController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Book a ticket for a concert.
     */
  

    /**
     * Redeem a ticket by unique code.
     */
    public function redeemTicket(Request $request)
    {
        $request->validate([
            'unique_code' => 'required|string',
        ]);

        $ticket = Ticket::where('unique_code', $request->unique_code)->first();

        if (!$ticket) {
            return response()->json(['error' => 'Invalid ticket code'], 404);
        }

        if ($ticket->used) {
            return response()->json(['error' => 'Ticket already used'], 400);
        }

        $ticket->used = true;
        $ticket->redeemed_at = now();
        $ticket->save();

        return response()->json(['message' => 'Ticket redeemed successfully']);
    }

    /**
     * Book a ticket for a concert.
     */
    public function bookTicket(Request $request, $concertId)
    {
        $concert = Concert::findOrFail($concertId);

        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
        ]);

        $ticketTypeId = $request->input('ticket_type_id');

        // Check if ticket type belongs to the concert
        $ticketType = $concert->ticketTypes()->where('id', $ticketTypeId)->first();
        if (!$ticketType) {
            return response()->json(['error' => 'Invalid ticket type selected'], 400);
        }

        // Check if quota is available for the ticket type
        $bookedCount = $concert->tickets()->where('ticket_type_id', $ticketTypeId)->count();
        if ($bookedCount >= $ticketType->quota) {
            return response()->json(['error' => 'No tickets available for the selected ticket type'], 400);
        }

        // Check if user has reached ticket limit for this concert
        $userTicketCount = Ticket::where('concert_id', $concert->id)
            ->where('user_id', $request->user()->id)
            ->count();

        if ($userTicketCount >= 5) {
            return response()->json(['error' => 'You have reached the maximum of 5 tickets for this concert'], 400);
        }

        // Generate unique code
        do {
            $uniqueCode = Str::upper(Str::random(10));
        } while (Ticket::where('unique_code', $uniqueCode)->exists());

        // Create ticket
        $ticket = Ticket::create([
            'concert_id' => $concert->id,
            'user_id' => $request->user()->id,
            'ticket_type_id' => $ticketTypeId,
            'unique_code' => $uniqueCode,
            'used' => false,
        ]);

        return response()->json(['message' => 'Ticket booked successfully', 'ticket' => $ticket], 201);
    }

    /**
     * New booking function as requested.
     */
    public function bookTicketNew(Request $request, $concertId)
    {
        $concert = Concert::findOrFail($concertId);

        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
        ]);

        $ticketTypeId = $request->input('ticket_type_id');

        // Check if ticket type belongs to the concert
        $ticketType = $concert->ticketTypes()->where('id', $ticketTypeId)->first();
        if (!$ticketType) {
            return response()->json(['error' => 'Invalid ticket type selected'], 400);
        }

        // Check if quota is available for the ticket type
        $bookedCount = $concert->tickets()->where('ticket_type_id', $ticketTypeId)->count();
        if ($bookedCount >= $ticketType->quota) {
            return response()->json(['error' => 'No tickets available for the selected ticket type'], 400);
        }

        // Check if user has reached ticket limit for this concert
        $userTicketCount = Ticket::where('concert_id', $concert->id)
            ->where('user_id', $request->user()->id)
            ->count();

        if ($userTicketCount >= 5) {
            return response()->json(['error' => 'You have reached the maximum of 5 tickets for this concert'], 400);
        }

        // Generate unique code
        do {
            $uniqueCode = Str::upper(Str::random(10));
        } while (Ticket::where('unique_code', $uniqueCode)->exists());

        // Create ticket
        $ticket = Ticket::create([
            'concert_id' => $concert->id,
            'user_id' => $request->user()->id,
            'ticket_type_id' => $ticketTypeId,
            'unique_code' => $uniqueCode,
            'used' => false,
        ]);

        return response()->json(['message' => 'New booking function: Ticket booked successfully', 'ticket' => $ticket], 201);
    }

    /**
     * Display the authenticated user's booked tickets.
     */
    public function myTickets(Request $request)
    {
        $user = $request->user();
        $tickets = $user->tickets()->with(['concert', 'ticketType'])->get();

        return view('tickets.my', compact('tickets'));
    }

    /**
     * Delete a ticket owned by the authenticated user.
     */
    public function destroy(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if ($ticket->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ticket->delete();

        return redirect()->route('tickets.my')->with('success', 'Ticket deleted successfully.');
    }

    /**
     * Display the details of a single ticket.
     */
    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if ($ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $ticket->load('concert');

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the redeem ticket form.
     */
    public function redeemForm()
    {
        return view('tickets.redeem');
    }

    /**
     * Display a list of all tickets with user and concert info for admin.
     */
    public function indexAdmin(Request $request)
    {
        $concertId = $request->query('concert_id');

        // If no concert_id provided, get the latest concert id
        if (!$concertId) {
            $latestConcert = Concert::orderBy('created_at', 'desc')->first();
            if ($latestConcert) {
                $concertId = $latestConcert->id;
            }
        }

        $query = Ticket::with(['user', 'concert', 'ticketType']);

        if ($concertId) {
            $query->where('concert_id', $concertId);
        }

        $tickets = $query->get();

        $soldTicketsCount = $tickets->count();
        $unusedTicketsCount = $tickets->where('used', false)->count();

        $concerts = Concert::select('id', 'title')->get();

        // Group tickets by ticketType name
        $groupedTickets = $tickets->groupBy(function ($ticket) {
            return $ticket->ticketType ? $ticket->ticketType->name : 'Unknown';
        });

        return view('tickets.index', compact('groupedTickets', 'soldTicketsCount', 'unusedTicketsCount', 'concerts', 'concertId'));
    }

    /**
     * Return tickets filtered by concert id for AJAX requests.
     */
    public function filterByConcert($concertId = null)
    {
        $query = Ticket::with(['user', 'concert']);

        if ($concertId) {
            $query->where('concert_id', $concertId);
        }

        $tickets = $query->get();

        $soldTicketsCount = $tickets->count();
        $unusedTicketsCount = $tickets->where('used', false)->count();

        return response()->json([
            'tickets' => $tickets,
            'soldTicketsCount' => $soldTicketsCount,
            'unusedTicketsCount' => $unusedTicketsCount,
        ]);
    }
}
