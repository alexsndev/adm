@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-2 sm:px-4 w-full">
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-8 w-full">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6 text-center bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent w-full">Editar Pessoa</h2>
            <form action="{{ route('previsibilidade.update', $pessoa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 w-full">
                @csrf
                @method('PUT')
                <div class="flex flex-col items-center mb-6">
                    <div class="w-28 h-28 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden mb-2">
                        @if($pessoa->photo)
                            <img id="photo-preview" src="{{ Storage::url($pessoa->photo) }}" alt="Foto atual" class="w-full h-full object-cover">
                        @else
                            <span id="photo-placeholder" class="text-gray-500 text-4xl">👤</span>
                        @endif
                    </div>
                    <input type="file" id="photo" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máximo: 2MB</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $pessoa->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                        <select id="category" name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="familia" @if($pessoa->category=='familia') selected @endif>Família</option>
                            <option value="amigo" @if($pessoa->category=='amigo') selected @endif>Amigo</option>
                            <option value="outro" @if($pessoa->category=='outro') selected @endif>Outro</option>
                        </select>
                    </div>
                    <div>
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Data de Nascimento</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $pessoa->birthdate) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $pessoa->phone) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $pessoa->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label for="details" class="block text-sm font-medium text-gray-700 mb-2">Detalhes</label>
                    <textarea id="details" name="details" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('details', $pessoa->details) }}</textarea>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $pessoa->notes) }}</textarea>
                </div>
                <div>
                    <label for="related" class="block text-sm font-medium text-gray-700 mb-2">Vincular a outras pessoas (opcional)</label>
                    <select id="related" name="related[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($outrasPessoas as $p)
                            <option value="{{ $p->id }}" @if($pessoa->relatedPeople->contains($p->id)) selected @endif>{{ $p->name }} ({{ ucfirst($p->category) }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Segure Ctrl (Windows) ou Command (Mac) para selecionar múltiplos.</p>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('previsibilidade.show', $pessoa->id) }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">Cancelar</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
    }
});
</script>
@endsection 