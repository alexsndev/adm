@extends('layouts.app')

@section('content')
    <div class="py-12 bg-main">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-success/10 border border-success text-success px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações do Evento -->
                <div class="lg:col-span-1">
                    <div class="bg-card glass-card overflow-hidden shadow-xl-custom rounded-3xl-custom">
                        <div class="p-6 text-main">
                            <h3 class="text-lg font-semibold mb-4 text-main">Informações do Evento</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-accent/80">Título</label>
                                    <p class="text-main">{{ $event->title }}</p>
                                </div>

                                @if($event->description)
                                    <div>
                                        <label class="text-sm font-medium text-accent/80">Descrição</label>
                                        <p class="text-main">{{ $event->description }}</p>
                                    </div>
                                @endif

                                <div>
                                    <label class="text-sm font-medium text-accent/80">Tipo</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent/10 text-accent capitalize">
                                        {{ $event->type }}
                                    </span>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-accent/80">Recorrência</label>
                                    <p class="text-main capitalize">{{ $event->recurrence_type }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-accent/80">Data de Início</label>
                                    <p class="text-main">{{ $event->start_date->format('d/m/Y') }}</p>
                                </div>

                                @if($event->end_date)
                                    <div>
                                        <label class="text-sm font-medium text-accent/80">Data de Fim</label>
                                        <p class="text-main">{{ $event->end_date->format('d/m/Y') }}</p>
                                    </div>
                                @endif

                                @if($event->time)
                                    <div>
                                        <label class="text-sm font-medium text-accent/80">Hora</label>
                                        <p class="text-main">{{ $event->time->format('H:i') }}</p>
                                    </div>
                                @endif

                                @if($event->location)
                                    <div>
                                        <label class="text-sm font-medium text-accent/80">Local</label>
                                        <p class="text-main">{{ $event->location }}</p>
                                    </div>
                                @endif

                                <div>
                                    <label class="text-sm font-medium text-accent/80">Lembrete</label>
                                    <p class="text-main">{{ $event->reminder_days }} dias antes</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-accent/80">Status</label>
                                    @if($event->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent/10 text-accent">
                                            Ativo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-main text-accent border border-main">
                                            Inativo
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-accent/80">Cor</label>
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded mr-2 border border-main" style="background-color: {{ $event->color }}"></div>
                                        <span class="text-main">{{ $event->color }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Ocorrências -->
                <div class="lg:col-span-2">
                    <div class="bg-card glass-card overflow-hidden shadow-xl-custom rounded-3xl-custom">
                        <div class="p-6 text-main">
                            <h3 class="text-lg font-semibold mb-4 text-main">Ocorrências</h3>
                            
                            @if($occurrences->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-main/30">
                                        <thead class="bg-main/80">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-accent/80 uppercase tracking-wider">Data</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-accent/80 uppercase tracking-wider">Hora</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-accent/80 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-accent/80 uppercase tracking-wider">Notas</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-accent/80 uppercase tracking-wider">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-card divide-y divide-main/30">
                                            @foreach($occurrences as $occurrence)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-main">
                                                        {{ $occurrence->formatted_date }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-main">
                                                        {{ $occurrence->formatted_time ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent/10 text-accent capitalize">
                                                            {{ $occurrence->status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-main">
                                                        {{ $occurrence->notes ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <form method="POST" action="{{ route('event-occurrences.status', $occurrence) }}" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" name="status" value="completed" class="text-accent hover:text-main mr-2">
                                                                Concluir
                                                            </button>
                                                            <button type="submit" name="status" value="cancelled" class="text-accent hover:text-main">
                                                                Cancelar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    {{ $occurrences->links() }}
                                </div>
                            @else
                                <p class="text-accent text-center py-8">Nenhuma ocorrência encontrada para este evento.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 