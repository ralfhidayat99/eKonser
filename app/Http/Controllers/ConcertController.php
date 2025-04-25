<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;

class ConcertController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display the specified concert detail page.
     */
    public function show(Concert $concert)
    {
        // Eager load ticket types with tickets
        $concert->load('ticketTypes');

        // Calculate available tickets per ticket type
        foreach ($concert->ticketTypes as $ticketType) {
            $soldCount = $concert->tickets()->where('ticket_type_id', $ticketType->id)->count();
            $ticketType->available = $ticketType->quota - $soldCount;
        }

        return view('concerts.show', compact('concert'));
    }

    /**
     * Display a listing of the concerts.
     */
    public function index()
    {
        $concerts = Concert::all();
        return view('concerts.index', compact('concerts'));
    }

    /**
     * Show the form for creating a new concert.
     */
    public function create()
    {
        
        return view('concerts.create');
    }

    /**
     * Store a newly created concert in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner' => 'nullable|string|max:255',
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:1',
            'tickets.*.type' => 'required|in:standing,seated',
        ]);

        $concert = Concert::create($request->only(['title', 'artist', 'date', 'location', 'banner']));

        foreach ($request->input('tickets') as $ticketData) {
            $concert->ticketTypes()->create($ticketData);
        }

        return redirect()->route('concerts.index')->with('success', 'Concert created successfully.');
    }

    /**
     * Show the form for editing the specified concert.
     */
    public function edit(Concert $concert)
    {
        return view('concerts.edit', compact('concert'));
    }

    /**
     * Update the specified concert in storage.
     */
    public function update(Request $request, Concert $concert)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner' => 'nullable|string|max:255',
            'tickets' => 'required|array|min:1',
            'tickets.*.id' => 'sometimes|integer|exists:ticket_types,id',
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:1',
            'tickets.*.type' => 'required|in:standing,seated',
        ]);

        $concert->update($request->only(['title', 'artist', 'date', 'location', 'banner']));

        $existingTicketTypeIds = $concert->ticketTypes()->pluck('id')->toArray();
        $submittedTicketTypeIds = collect($request->input('tickets'))->pluck('id')->filter()->toArray();

        // Delete ticket types that are removed in the form but only if they have no tickets
        $ticketTypesToDelete = array_diff($existingTicketTypeIds, $submittedTicketTypeIds);
        if (!empty($ticketTypesToDelete)) {
            $ticketTypesWithTickets = $concert->tickets()
                ->whereIn('ticket_type_id', $ticketTypesToDelete)
                ->pluck('ticket_type_id')
                ->unique()
                ->toArray();

            $ticketTypesSafeToDelete = array_diff($ticketTypesToDelete, $ticketTypesWithTickets);

            if (!empty($ticketTypesSafeToDelete)) {
                $concert->ticketTypes()->whereIn('id', $ticketTypesSafeToDelete)->delete();
            }
        }

        foreach ($request->input('tickets') as $ticketData) {
            if (isset($ticketData['id']) && in_array($ticketData['id'], $existingTicketTypeIds)) {
                // Update existing ticket type
                $concert->ticketTypes()->where('id', $ticketData['id'])->update([
                    'name' => $ticketData['name'],
                    'price' => $ticketData['price'],
                    'quota' => $ticketData['quota'],
                    'type' => $ticketData['type'],
                ]);
            } else {
                // Create new ticket type
                $concert->ticketTypes()->create($ticketData);
            }
        }

        return redirect()->route('concerts.detail', $concert)->with('success', 'Concert updated successfully.');
    }

    /**
     * Remove the specified concert from storage.
     */
    public function destroy(Concert $concert)
    {
        $concert->delete();

        return redirect()->route('concerts.index')->with('success', 'Concert deleted successfully.');
    }

    /**
     * Display the detailed concert page.
     */
    public function detail(Concert $concert)
    {
        // Eager load ticket types with tickets and users
        $concert->load(['ticketTypes', 'tickets.user']);

        // Calculate available tickets per ticket type
        foreach ($concert->ticketTypes as $ticketType) {
            $soldCount = $concert->tickets->where('ticket_type_id', $ticketType->id)->count();
            $ticketType->sold = $soldCount;
            $ticketType->available = $ticketType->quota - $soldCount;
        }

        // Group tickets by ticket type and then by user
        $groupedUserTickets = $concert->tickets
            ->groupBy('ticket_type_id')
            ->map(function ($ticketsByType) {
                $userTickets = $ticketsByType
                    ->groupBy('user_id')
                    ->map(function ($tickets, $userId) {
                        return [
                            'user' => $tickets->first()->user,
                            'count' => $tickets->count(),
                        ];
                    })
                    ->values();
                return [
                    'ticketType' => $ticketsByType->first()->ticketType,
                    'userTickets' => $userTickets,
                ];
            });

        return view('concerts.detail', ['concert' => $concert, 'groupedUserTickets' => $groupedUserTickets]);
    }
}
