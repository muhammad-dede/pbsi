<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentOfficial\StoreRequest;
use App\Http\Requests\TournamentOfficial\UpdateRequest;
use App\Models\Country;
use App\Models\OfficialRole;
use App\Models\Tournament;
use App\Models\TournamentOfficial;
use App\Traits\HasPermissionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TournamentOfficialController extends Controller
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

        $data = TournamentOfficial::query()
            ->with(['tournament', 'official', 'country'])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('tournament', function ($t) use ($search) {
                            $t->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('official', function ($t) use ($search) {
                            $t->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('country', function ($t) use ($search) {
                            $t->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->withQueryString();

        return Inertia::render('tournament-officials/Index', [
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
        $official_roles = OfficialRole::all();
        $countries = Country::all();

        return Inertia::render('tournament-officials/Create', [
            'tournaments' => $tournaments,
            'official_roles' => $official_roles,
            'countries' => $countries,
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
            TournamentOfficial::create([
                'tournament_id' => $validated['tournament_id'],
                'official_role_code' => $validated['official_role_code'],
                'name' => strtoupper($validated['name']),
                'country_code' => strtoupper($validated['country_code']),
            ]);
        });

        return redirect()->route('tournament-officials.index')->with('success', 'Official turnamen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkPermission('edit_tournament');

        $tournament_official = TournamentOfficial::findOrFail($id);
        $tournaments = Tournament::all();
        $official_roles = OfficialRole::all();
        $countries = Country::all();

        return Inertia::render('tournament-officials/Edit', [
            'tournament_official' => $tournament_official,
            'tournaments' => $tournaments,
            'official_roles' => $official_roles,
            'countries' => $countries,
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
            $tournament_official = TournamentOfficial::findOrFail($id);
            $tournament_official->update([
                'tournament_id' => $validated['tournament_id'],
                'official_role_code' => $validated['official_role_code'],
                'name' => strtoupper($validated['name']),
                'country_code' => strtoupper($validated['country_code']),
            ]);
        });

        return redirect()->route('tournament-officials.index')->with('success', 'Official turnamen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkPermission('delete_tournament');

        DB::transaction(function () use ($id) {
            $tournament_official = TournamentOfficial::findOrFail($id);
            $tournament_official->delete();
        });

        return redirect()->route('tournament-officials.index')->with('success', 'Official turnamen berhasil dihapus.');
    }
}
