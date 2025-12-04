<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hotel\StoreRequest;
use App\Http\Requests\Hotel\UpdateRequest;
use App\Models\Currency;
use App\Models\Hotel;
use App\Models\Tournament;
use Inertia\Inertia;
use App\Traits\HasPermissionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
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

        $data = Hotel::query()
            ->with(['tournament'])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('tournament', function ($t) use ($search) {
                            $t->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->withQueryString();

        return Inertia::render('hotels/Index', [
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
        $currencies = Currency::all();

        return Inertia::render('hotels/Create', [
            'tournaments' => $tournaments,
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
            Hotel::create([
                'tournament_id' => $validated['tournament_id'],
                'name' => strtoupper($validated['name']),
                'address' => $validated['address'],
                'rate_single' => $validated['rate_single'],
                'rate_double' => $validated['rate_double'],
                'rate_twin' => $validated['rate_twin'],
                'currency_code' => $validated['currency_code'],
                'facilities' => $validated['facilities'],
                'breakfast_included' => $validated['breakfast_included'],
                'breakfast_persons' => $validated['breakfast_persons'],
                'is_official' => $validated['is_official'],
            ]);
        });

        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->checkPermission('view_tournament');

        $hotel = Hotel::findOrFail($id);
        $tournaments = Tournament::all();
        $currencies = Currency::all();

        return Inertia::render('hotels/Show', [
            'hotel' => $hotel,
            'tournaments' => $tournaments,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkPermission('edit_tournament');

        $hotel = Hotel::findOrFail($id);
        $tournaments = Tournament::all();
        $currencies = Currency::all();

        return Inertia::render('hotels/Edit', [
            'hotel' => $hotel,
            'tournaments' => $tournaments,
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
            $hotel = Hotel::findOrFail($id);
            $hotel->update([
                'tournament_id' => $validated['tournament_id'],
                'name' => strtoupper($validated['name']),
                'address' => $validated['address'],
                'rate_single' => $validated['rate_single'],
                'rate_double' => $validated['rate_double'],
                'rate_twin' => $validated['rate_twin'],
                'currency_code' => $validated['currency_code'],
                'facilities' => $validated['facilities'],
                'breakfast_included' => $validated['breakfast_included'],
                'breakfast_persons' => $validated['breakfast_persons'],
                'is_official' => $validated['is_official'],
            ]);
        });

        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkPermission('delete_tournament');

        DB::transaction(function () use ($id) {
            $hotel = Hotel::findOrFail($id);
            $hotel->delete();
        });

        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil dihapus.');
    }
}
