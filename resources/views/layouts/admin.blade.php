@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('components.layout.header', ['theme' => $theme ?? 'system'])
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        @include('components.layout.sidebar')
    </div>
    <div class="lg:pl-72">
        <main id="main-content" class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</div>
@endsection 