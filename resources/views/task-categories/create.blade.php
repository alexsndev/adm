@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="w-full px-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('task-categories.store') }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nome da Categoria')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="color" :value="__('Cor')" />
                            <select id="color" name="color" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Azul</option>
                                <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Vermelho</option>
                                <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Verde</option>
                                <option value="yellow" {{ old('color') == 'yellow' ? 'selected' : '' }}>Amarelo</option>
                                <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Roxo</option>
                                <option value="pink" {{ old('color') == 'pink' ? 'selected' : '' }}>Rosa</option>
                                <option value="indigo" {{ old('color') == 'indigo' ? 'selected' : '' }}>Índigo</option>
                                <option value="gray" {{ old('color') == 'gray' ? 'selected' : '' }}>Cinza</option>
                                <option value="orange" {{ old('color') == 'orange' ? 'selected' : '' }}>Laranja</option>
                                <option value="teal" {{ old('color') == 'teal' ? 'selected' : '' }}>Verde-azulado</option>
                            </select>
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="icon" :value="__('Ícone (FontAwesome)')" />
                            <x-text-input id="icon" class="block mt-1 w-full" type="text" name="icon" :value="old('icon')" placeholder="fas fa-home" />
                            <p class="text-sm text-gray-500 mt-1">Exemplo: fas fa-home, fas fa-utensils, fas fa-broom</p>
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Categoria ativa') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                <i class="fas fa-save mr-2"></i>{{ __('Criar Categoria') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 