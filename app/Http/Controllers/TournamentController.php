<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tournament\StoreRequest;
use App\Http\Requests\Tournament\UpdateRequest;
use App\Models\Currency;
use App\Models\Tournament;
use App\Traits\HasPermissionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TournamentController extends Controller
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

        $data = Tournament::query()
            ->with(['currency'])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sanction', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->withQueryString();

        return Inertia::render('tournaments/Index', [
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

        $currencies = Currency::all();

        return Inertia::render('tournaments/Create', [
            'currencies' => $currencies,
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
            Tournament::create([
                'name' => strtoupper($validated['name']),
                'title' => strtoupper($validated['title']),
                'prize_money' => $validated['prize_money'],
                'currency_code' => strtoupper($validated['currency_code']),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'venue_name' => $validated['venue_name'],
                'venue_address' => $validated['venue_address'],
                'organizer' => $validated['organizer'],
                'organizer_address' => $validated['organizer_address'],
                'sanction' => $validated['sanction'],
                'official_shuttlecock' => $validated['official_shuttlecock'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->checkPermission('view_tournament');

        $tournament = Tournament::findOrFail($id);
        $currencies = Currency::all();

        return Inertia::render('tournaments/Show', [
            'tournament' => $tournament,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkPermission('edit_tournament');

        $tournament = Tournament::findOrFail($id);
        $currencies = Currency::all();

        return Inertia::render('tournaments/Edit', [
            'tournament' => $tournament,
            'currencies' => $currencies,
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
            $tournament = Tournament::findOrFail($id);
            $tournament->update([
                'name' => strtoupper($validated['name']),
                'title' => strtoupper($validated['title']),
                'prize_money' => $validated['prize_money'],
                'currency_code' => strtoupper($validated['currency_code']),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'venue_name' => $validated['venue_name'],
                'venue_address' => $validated['venue_address'],
                'organizer' => $validated['organizer'],
                'organizer_address' => $validated['organizer_address'],
                'sanction' => $validated['sanction'],
                'official_shuttlecock' => $validated['official_shuttlecock'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkPermission('delete_tournament');

        DB::transaction(function () use ($id) {
            $tournament = Tournament::findOrFail($id);
            $tournament->delete();
        });

        return redirect()->route('tournaments.index')->with('success', 'Turnamen berhasil dihapus.');
    }
}
