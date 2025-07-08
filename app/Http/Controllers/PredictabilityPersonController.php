<?php

namespace App\Http\Controllers;

use App\Models\PredictabilityPerson;
use App\Models\PredictabilityPersonAttachment;
use App\Models\PredictabilityPersonLink;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PredictabilityPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = PredictabilityPerson::with('attachments', 'relatedPeople')->get()->unique('id');
        return view('previsibilidade.index', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pessoas = PredictabilityPerson::all();
        return view('previsibilidade.create', compact('pessoas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:familia,amigo,outro',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'details' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'related' => 'nullable|array',
            'related.*' => 'exists:predictability_people,id',
        ]);

        $data = $request->except('related');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('predictability/photos', 'public');
        }
        $pessoa = PredictabilityPerson::create($data);

        // Se a pessoa tem data de nascimento, cria o evento de aniversário
        if (!empty($pessoa->birthdate)) {
            $birthdate = Carbon::parse($pessoa->birthdate);
            $now = Carbon::now();
            $nextBirthday = $birthdate->copy()->year($now->year);
            if ($nextBirthday->isPast()) {
                $nextBirthday->addYear();
            }
            $evento = Event::create([
                'title' => 'Aniversário de ' . $pessoa->name,
                'description' => 'Aniversário de ' . $pessoa->name,
                'type' => 'birthday',
                'recurrence_type' => 'yearly',
                'start_date' => $nextBirthday->format('Y-m-d'),
                'end_date' => null,
                'user_id' => auth()->id(),
                'color' => '#3B82F6',
            ]);
            $evento->predictabilityPeople()->sync([$pessoa->id]);
        }

        // Linkar pessoas
        if ($request->has('related')) {
            foreach ($request->related as $relacionada_id) {
                PredictabilityPersonLink::create([
                    'pessoa_id' => $pessoa->id,
                    'relacionada_id' => $relacionada_id,
                ]);
            }
        }

        return redirect()->route('previsibilidade.show', $pessoa->id)->with('success', 'Pessoa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pessoa = PredictabilityPerson::with(['attachments', 'relatedPeople'])->findOrFail($id);
        $outrasPessoas = PredictabilityPerson::where('id', '!=', $id)->get();
        return view('previsibilidade.show', compact('pessoa', 'outrasPessoas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pessoa = PredictabilityPerson::with(['attachments', 'relatedPeople'])->findOrFail($id);
        $outrasPessoas = PredictabilityPerson::where('id', '!=', $id)->get();
        return view('previsibilidade.edit', compact('pessoa', 'outrasPessoas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pessoa = PredictabilityPerson::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:familia,amigo,outro',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'details' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'related' => 'nullable|array',
            'related.*' => 'exists:predictability_people,id',
        ]);

        $data = $request->except('related');
        if ($request->hasFile('photo')) {
            if ($pessoa->photo) {
                Storage::disk('public')->delete($pessoa->photo);
            }
            $data['photo'] = $request->file('photo')->store('predictability/photos', 'public');
        }
        $pessoa->update($data);

        // Atualizar links
        PredictabilityPersonLink::where('pessoa_id', $pessoa->id)->delete();
        if ($request->has('related')) {
            foreach ($request->related as $relacionada_id) {
                PredictabilityPersonLink::create([
                    'pessoa_id' => $pessoa->id,
                    'relacionada_id' => $relacionada_id,
                ]);
            }
        }

        return redirect()->route('previsibilidade.show', $pessoa->id)->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pessoa = PredictabilityPerson::findOrFail($id);
        if ($pessoa->photo) {
            Storage::disk('public')->delete($pessoa->photo);
        }
        $pessoa->attachments()->delete();
        PredictabilityPersonLink::where('pessoa_id', $pessoa->id)->orWhere('relacionada_id', $pessoa->id)->delete();
        $pessoa->delete();
        return redirect()->route('previsibilidade.index')->with('success', 'Pessoa removida com sucesso!');
    }

    public function addAttachment(Request $request, $id)
    {
        $pessoa = \App\Models\PredictabilityPerson::findOrFail($id);
        $request->validate([
            'arquivo' => 'required|file|max:8192',
            'descricao' => 'nullable|string|max:255',
        ]);
        $path = $request->file('arquivo')->store('predictability/attachments', 'public');
        $pessoa->attachments()->create([
            'arquivo' => $path,
            'descricao' => $request->descricao,
        ]);
        return redirect()->route('previsibilidade.show', $pessoa->id)->with('success', 'Anexo adicionado com sucesso!');
    }
}
