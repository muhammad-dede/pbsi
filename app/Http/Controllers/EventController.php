<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreRequest;
use App\Http\Requests\Event\UpdateRequest;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Round;
use App\Models\Tournament;
use App\Traits\HasPermissionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventController extends Controller
{
    use HasPermissionCheck;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkPermission('view_any_tournament');

        $filters = $request->only(['search', 'per_page']);
        $search = $filters['search'] ?? null;
        $per_page = $filters['per_page'] ?? 5;

        $data = Event::query()
            ->with(['tournament', 'eventCategory', 'prizeDistributions'])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->orWhereHas('tournament', function ($t) use ($search) {
                        $t->where('name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('eventCategory', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->withQueryString();

        return Inertia::render('events/Index', [
            'filters' => $filters,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkPermission('create_tournament');

        $tournaments = Tournament::all();
        $event_categories = EventCategory::all();
        $rounds = Round::all();

        return Inertia::render('events/Create', [
            'tournaments' => $tournaments,
            'event_categories' => $event_categories,
            'rounds' => $rounds,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->checkPermission('create_tournament');

        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $event = Event::create([
                'tournament_id' => $validated['tournament_id'],
                'event_category_code' => $validated['event_category_code'],
                'main_draw_size' => $validated['main_draw_size'],
                'qualifying_positions' => $validated['qualifying_positions'],
                'max_qualifying_entries' => $validated['max_qualifying_entries'],
            ]);
            if (isset($validated['prize_distributions']) && is_array($validated['prize_distributions'])) {
                foreach ($validated['prize_distributions'] as $prize_distributions) {
                    $event->prizeDistributions()->create([
                        'round_code' => $prize_distributions['round_code'],
                        'amount' => $prize_distributions['amount'],
                        'is_per_pair' => $prize_distributions['is_per_pair'],
                    ]);
                }
            }
        });

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->checkPermission('view_tournament');

        $event = Event::with('prizeDistributions')->findOrFail($id);
        $tournaments = Tournament::all();
        $event_categories = EventCategory::all();
        $rounds = Round::all();

        return Inertia::render('events/Show', [
            'event' => $event,
            'tournaments' => $tournaments,
            'event_categories' => $event_categories,
            'rounds' => $rounds,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkPermission('edit_tournament');

        $event = Event::with('prizeDistributions')->findOrFail($id);
        $tournaments = Tournament::all();
        $event_categories = EventCategory::all();
        $rounds = Round::all();

        return Inertia::render('events/Edit', [
            'event' => $event,
            'tournaments' => $tournaments,
            'event_categories' => $event_categories,
            'rounds' => $rounds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $this->checkPermission('edit_tournament');

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $id) {
            $event = Event::findOrFail($id);
            $event->update([
                'tournament_id' => $validated['tournament_id'],
                'event_category_code' => $validated['event_category_code'],
                'main_draw_size' => $validated['main_draw_size'],
                'qualifying_positions' => $validated['qualifying_positions'],
                'max_qualifying_entries' => $validated['max_qualifying_entries'],
            ]);
            if (isset($validated['prize_distributions']) && is_array($validated['prize_distributions'])) {
                $submittedIds = collect($validated['prize_distributions'])
                    ->pluck('id')
                    ->filter()
                    ->toArray();
                $event->prizeDistributions()
                    ->whereNotIn('id', $submittedIds)
                    ->delete();
                foreach ($validated['prize_distributions'] as $pd) {
                    $event->prizeDistributions()->updateOrCreate(
                        [
                            'id' => $pd['id'],
                        ],
                        [
                            'round_code' => $pd['round_code'],
                            'amount' => $pd['amount'],
                            'is_per_pair' => $pd['is_per_pair'],
                        ]
                    );
                }
            }
        });

        return redirect()->route('events.index')->with('success', 'Event berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkPermission('delete_tournament');

        DB::transaction(function () use ($id) {
            $event = Event::findOrFail($id);
            $event->prizeDistributions()->delete();
            $event->delete();
        });

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
    }
}
