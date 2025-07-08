<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventOccurrence;
use App\Models\PredictabilityPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->with(['occurrences' => function($query) {
                $query->where('occurrence_date', '>=', Carbon::now()->format('Y-m-d'))
                      ->where('status', 'pending')
                      ->orderBy('occurrence_date');
            }, 'predictabilityPeople'])
            ->orderBy('title')
            ->get();

        $upcomingOccurrences = EventOccurrence::whereHas('event', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('occurrence_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('status', 'pending')
            ->with(['event.predictabilityPeople'])
            ->orderBy('occurrence_date')
            ->limit(10)
            ->get();

        return view('events.index', compact('events', 'upcomingOccurrences'));
    }

    public function create()
    {
        $pessoas = PredictabilityPerson::orderBy('name')->get();
        return view('events.create', compact('pessoas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:birthday,anniversary,holiday,custom',
            'recurrence_type' => 'required|in:yearly,monthly,weekly,daily,once',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'reminder_days' => 'integer|min:0|max:365',
            'color' => 'nullable|string|max:7',
            'predictability_people' => 'nullable|array',
            'predictability_people.*' => 'exists:predictability_people,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['color'] = $validated['color'] ?? '#3B82F6';

        $event = Event::create($validated);

        // Vincular pessoas de previsibilidade
        if ($request->has('predictability_people')) {
            $event->predictabilityPeople()->sync($request->predictability_people);
        }

        // Gerar ocorrências para o próximo ano
        $event->generateOccurrences();

        return redirect()->route('events.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $occurrences = $event->occurrences()
            ->orderBy('occurrence_date', 'desc')
            ->paginate(20);

        return view('events.show', compact('event', 'occurrences'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:birthday,anniversary,holiday,custom',
            'recurrence_type' => 'required|in:yearly,monthly,weekly,daily,once',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'reminder_days' => 'integer|min:0|max:365',
            'color' => 'nullable|string|max:7',
        ]);

        $event->update($validated);

        // Regenerar ocorrências se necessário
        if ($request->has('regenerate_occurrences')) {
            $event->occurrences()->delete();
            $event->generateOccurrences();
        }

        return redirect()->route('events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Evento excluído com sucesso!');
    }

    public function calendar(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        $occurrences = EventOccurrence::whereHas('event', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereYear('occurrence_date', $year)
            ->whereMonth('occurrence_date', $month)
            ->with(['event.predictabilityPeople'])
            ->get()
            ->groupBy('occurrence_date');

        return view('events.calendar', compact('occurrences', 'year', 'month'));
    }

    public function updateOccurrenceStatus(Request $request, EventOccurrence $occurrence)
    {
        $this->authorize('update', $occurrence->event);

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $occurrence->update($validated);

        return back()->with('success', 'Status da ocorrência atualizado!');
    }

    public function generateOccurrences(Event $event)
    {
        $this->authorize('update', $event);

        $event->occurrences()->delete();
        $event->generateOccurrences();

        return back()->with('success', 'Ocorrências regeneradas com sucesso!');
    }

    /**
     * Força a geração de ocorrências para todos os eventos ativos do usuário logado
     */
    public function forceGenerateAllOccurrences()
    {
        $events = Event::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();
        foreach ($events as $event) {
            $event->occurrences()->delete();
            $event->generateOccurrences();
        }
        return redirect()->route('events.index')->with('success', 'Ocorrências regeneradas para todos os eventos ativos!');
    }

    public function search(Request $request)
    {
        $term = strtolower($request->get('q', ''));
        if (!$term) {
            return response()->json([]);
        }
        $occurrences = \App\Models\EventOccurrence::whereHas('event', function($query) use ($term) {
                $query->where('user_id', Auth::id())
                      ->whereRaw('LOWER(title) LIKE ?', ["%{$term}%"]);
            })
            ->where('occurrence_date', '>=', Carbon::now()->format('Y-m-d'))
            ->with('event')
            ->orderBy('occurrence_date')
            ->limit(10)
            ->get();
        $results = $occurrences->map(function($occ) {
            return [
                'title' => $occ->event->title,
                'date' => $occ->occurrence_date,
                'type' => $occ->event->type,
                'id' => $occ->event->id,
            ];
        });
        return response()->json($results);
    }
} 