<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedule\StoreRequest;
use App\Http\Requests\Schedule\UpdateRequest;
use App\Models\Schedule;
use App\Models\SessionType;
use App\Models\Tournament;
use App\Traits\HasPermissionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ScheduleController extends Controller
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

        $data = Schedule::query()
            ->with(['tournament', 'sessionType'])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('event_description', 'like', "%{$search}%")
                        ->orWhereHas('tournament', function ($t) use ($search) {
                            $t->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('sessionType', function ($t) use ($search) {
                            $t->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->withQueryString();

        return Inertia::render('schedules/Index', [
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
        $session_types = SessionType::all();

        return Inertia::render('schedules/Create', [
            'tournaments' => $tournaments,
            'session_types' => $session_types,
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
            Schedule::create([
                'tournament_id' => $validated['tournament_id'],
                'date' => $validated['date'],
                'event_description' => $validated['event_description'],
                'session_type_code' => $validated['session_type_code'],
                'courts_available' => $validated['courts_available'],
                'doors_open' => $validated['doors_open'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);
        });

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->checkPermission('view_tournament');

        $schedule = Schedule::findOrFail($id);
        $tournaments = Tournament::all();
        $session_types = SessionType::all();

        return Inertia::render('schedules/Show', [
            'schedule' => $schedule,
            'tournaments' => $tournaments,
            'session_types' => $session_types,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkPermission('edit_tournament');

        $schedule = Schedule::findOrFail($id);
        $tournaments = Tournament::all();
        $session_types = SessionType::all();

        return Inertia::render('schedules/Edit', [
            'schedule' => $schedule,
            'tournaments' => $tournaments,
            'session_types' => $session_types,
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
            $schedule = Schedule::findOrFail($id);
            $schedule->update([
                'tournament_id' => $validated['tournament_id'],
                'date' => $validated['date'],
                'event_description' => $validated['event_description'],
                'session_type_code' => $validated['session_type_code'],
                'courts_available' => $validated['courts_available'],
                'doors_open' => $validated['doors_open'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);
        });

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkPermission('delete_tournament');

        DB::transaction(function () use ($id) {
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();
        });

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
