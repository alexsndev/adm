<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <label for="photo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Foto de Perfil</label>
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-slate-200 dark:bg-slate-700 rounded-full flex items-center justify-center overflow-hidden">
                    @if($user->photo)
                        <img id="photo-preview" src="{{ Storage::url($user->photo) }}" alt="Foto de perfil" class="w-full h-full object-cover">
                    @else
                        <span id="photo-placeholder" class="text-slate-500 dark:text-slate-400 text-2xl">👤</span>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="photo" name="photo" accept="image/*" 
                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all duration-200">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Formatos: JPG, PNG, GIF. Máximo: 2MB</p>
                </div>
            </div>
        </div>
        <!-- Campo de upload de logo personalizada -->
        <div class="mt-6">
            <label for="logo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Logo personalizada</label>
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-600">
                    @if($user->logo)
                        <img id="logo-preview" src="{{ Storage::url($user->logo) }}" alt="Logo atual" class="w-full h-full object-contain">
                    @else
                        <span id="logo-placeholder" class="text-slate-400 dark:text-slate-500 text-2xl">🏷️</span>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="logo" name="logo" accept="image/*" 
                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900/30 dark:file:text-green-400 transition-all duration-200">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Formatos: JPG, PNG, GIF. Máximo: 2MB</p>
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Digite seu nome" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" :value="old('email', $user->email)" required autocomplete="username" placeholder="Digite seu email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-600 dark:text-slate-300">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600 dark:text-slate-300"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
document.getElementById('photo')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('photo-preview');
    const placeholder = document.getElementById('photo-placeholder');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        if (preview) preview.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
    }
});
// Preview para logo personalizada

document.getElementById('logo')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('logo-preview');
    const placeholder = document.getElementById('logo-placeholder');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        if (preview) preview.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
    }
});
</script>
