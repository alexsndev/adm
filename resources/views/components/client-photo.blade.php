@props(['client', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'w-8 h-8',
        'md' => 'w-12 h-12', 
        'lg' => 'w-16 h-16',
        'xl' => 'w-24 h-24',
        '2xl' => 'w-32 h-32'
    ];
    
    $sizeClass = $sizeClasses[$size] ?? 'w-12 h-12';
@endphp

@if($client && $client->photo)
    <img src="{{ Storage::url($client->photo) }}" 
         alt="Foto de {{ $client->name }}" 
         class="{{ $sizeClass }} rounded-full object-cover {{ $attributes->get('class') }}">
@else
    <div class="{{ $sizeClass }} bg-gray-200 rounded-full flex items-center justify-center {{ $attributes->get('class') }}">
        <span class="text-gray-500 {{ $size === 'sm' ? 'text-sm' : ($size === 'lg' ? 'text-xl' : ($size === 'xl' ? 'text-2xl' : ($size === '2xl' ? 'text-4xl' : 'text-lg'))) }}">👤</span>
    </div>
@endif 