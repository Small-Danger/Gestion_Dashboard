@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Compagnies</h1>
        <button onclick="openModal('create-modal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Nouvelle Compagnie
        </button>
    </div>

    <!-- Version mobile -->
    <div class="sm:hidden bg-white rounded-lg shadow overflow-hidden">
        @forelse($companies as $company)
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center space-x-3 mb-2">
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo {{ $company->name }}" class="h-10 w-10 rounded-full object-cover">
                @else
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $company->name }}</p>
                    <p class="text-sm text-gray-500 truncate">{{ $company->description ?? 'N/A' }}</p>
                </div>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $company->calculateCurrentBalance() >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ number_format($company->calculateCurrentBalance(), 2) }} Kg
                </span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <a href="{{ route('companies.stock.destinations', $company) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Voir Stocks
                    <span class="ml-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-indigo-500 rounded-full">
                        {{ $company->destinations_count ?? $company->destinations()->count() }}
                    </span>
                </a>
                <div class="flex space-x-4">
                    <button onclick="openEditModal('{{ $company->id }}', '{{ $company->name }}', `{{ $company->description ?? '' }}`, '{{ $company->logo ? asset('storage/' . $company->logo) : '' }}', '{{ $company->calculateCurrentBalance() }}')" class="text-blue-600 hover:text-blue-900 text-sm">Modifier</button>
                    <button onclick="openDeleteModal('{{ $company->id }}')" class="text-red-600 hover:text-red-900 text-sm">Supprimer</button>
                </div>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-sm text-gray-500">Aucune compagnie trouvée</div>
        @endforelse
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $companies->links() }}
        </div>
    </div>

    <!-- Version desktop -->
    <div class="hidden sm:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($companies as $company)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo {{ $company->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 max-w-xs truncate">{{ $company->description ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $company->calculateCurrentBalance() >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ number_format($company->calculateCurrentBalance(), 2) }} Kg
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            <button onclick="openEditModal('{{ $company->id }}', '{{ $company->name }}', `{{ $company->description ?? '' }}`, '{{ $company->logo ? asset('storage/' . $company->logo) : '' }}', '{{ $company->calculateCurrentBalance() }}')" class="text-blue-600 hover:text-blue-900">Modifier</button>
                            <button onclick="openDeleteModal('{{ $company->id }}')" class="text-red-600 hover:text-red-900">Supprimer</button>
                            <td><a href="{{ route('companies.stock.destinations', $company) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Voir Stocks
                                <span class="ml-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-indigo-500 rounded-full">
                                    {{ $company->destinations_count ?? $company->destinations()->count() }}
                                </span>
                            </a></td>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Aucune compagnie trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $companies->links() }}
        </div>
    </div>
</div>

<!-- Modale de création -->
<div id="create-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" onclick="closeModal('create-modal')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ajouter une nouvelle compagnie</h3>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="create_name" class="block text-sm font-medium text-gray-700">Nom *</label>
                                    <input type="text" name="name" id="create_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_logo" class="block text-sm font-medium text-gray-700">Logo</label>
                                    <input type="file" name="logo" id="create_logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @error('logo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="create_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="balance" class="block text-sm font-medium text-gray-700">Solde initial (Kg)</label>
                                    <input type="number" step="0.01" name="balance" id="balance" value="0"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('balance')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal('create-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modale d'édition -->
<div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" onclick="closeModal('edit-modal')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Modifier la compagnie</h3>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Nom *</label>
                                    <input type="text" name="name" id="edit_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_logo" class="block text-sm font-medium text-gray-700">Logo</label>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <img id="edit_logo_preview" src="" alt="Logo actuel" class="h-16 w-16 rounded-full object-cover hidden">
                                        <input type="file" name="logo" id="edit_logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Laissez vide pour conserver le logo actuel</p>
                                </div>
                                <div>
                                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="edit_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                                <div>
                                    <label for="edit_balance" class="block text-sm font-medium text-gray-700">Solde (Kg)</label>
                                    <input type="number" step="0.01" name="balance" id="edit_balance"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mettre à jour
                    </button>
                    <button type="button" onclick="closeModal('edit-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modale de suppression -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" onclick="closeModal('delete-modal')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmer la suppression</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir supprimer cette compagnie ? Toutes les destinations associées seront également supprimées. Cette action est irréversible.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Supprimer
                    </button>
                    <button type="button" onclick="closeModal('delete-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notifications -->
@if(session('success'))
<div id="notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center justify-between">
    <span>{{ session('success') }}</span>
    <button onclick="document.getElementById('notification').remove()" class="ml-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
</div>
<script>
    setTimeout(() => {
        document.getElementById('notification')?.remove();
    }, 5000);
</script>
@endif

<script>
    // Gestion des modales
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Pré-remplir et ouvrir la modale d'édition
    function openEditModal(id, name, description, logoUrl, balance) {
        document.getElementById('edit-form').action = `/companies/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_balance').value = balance;
        
        const logoPreview = document.getElementById('edit_logo_preview');
        if (logoUrl) {
            logoPreview.src = logoUrl;
            logoPreview.classList.remove('hidden');
        } else {
            logoPreview.classList.add('hidden');
        }
        
        openModal('edit-modal');
    }

    // Configurer la modale de suppression
    function openDeleteModal(id) {
        document.getElementById('delete-form').action = `/companies/${id}`;
        openModal('delete-modal');
    }

    // Prévisualisation du logo avant upload
    document.getElementById('create_logo')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                // Vous pourriez ajouter une prévisualisation ici si besoin
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection