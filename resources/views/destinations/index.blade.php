@extends('layouts.app')

@section('title', 'Gestion des Destinations')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Gestion des Destinations</h1>
        <button onclick="openModal('create-modal')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg flex items-center text-sm sm:text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Nouvelle Destination
        </button>
    </div>

    <!-- Filtre par compagnie - Version Responsive -->
    <div class="bg-white rounded-lg shadow p-3 sm:p-4 mb-4 sm:mb-6">
        <form method="GET" action="{{ route('destinations.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
            <div class="w-full sm:w-64">
                <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par compagnie</label>
                <select id="company_id" name="company_id" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                    <option value="">Toutes les compagnies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            @if($companyId)
                <a href="{{ route('destinations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm self-center sm:self-end sm:mb-1">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Version Mobile - Liste en cartes -->
    <div class="sm:hidden bg-white rounded-lg shadow overflow-hidden mb-6">
        @forelse($destinations as $destination)
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <div class="font-medium text-gray-900">{{ $destination->company->name }}</div>
                    <div class="mt-1 text-sm text-gray-600">
                        <span class="font-medium">{{ $destination->country }}</span>
                        @if($destination->city)
                            - {{ $destination->city }}
                        @else
                            <span class="text-gray-400">(N/A)</span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button onclick="openEditModal('{{ $destination->id }}', '{{ $destination->company_id }}', '{{ $destination->country }}', '{{ $destination->city }}')" 
                            class="text-blue-600 hover:text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button onclick="openDeleteModal('{{ $destination->id }}')" 
                            class="text-red-600 hover:text-red-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-sm text-gray-500">Aucune destination trouvée</div>
        @endforelse
        <!-- Pagination Mobile -->
        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $destinations->links() }}
        </div>
    </div>

    <!-- Version Desktop - Tableau -->
    <div class="hidden sm:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compagnie</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pays</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($destinations as $destination)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">{{ $destination->company->name }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $destination->country }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $destination->city ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openEditModal('{{ $destination->id }}', '{{ $destination->company_id }}', '{{ $destination->country }}', '{{ $destination->city }}')" 
                                    class="text-blue-600 hover:text-blue-900 mr-4">Modifier</button>
                            <button onclick="openDeleteModal('{{ $destination->id }}')" 
                                    class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Aucune destination trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination Desktop -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $destinations->links() }}
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
            <form action="{{ route('destinations.store') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ajouter une nouvelle destination</h3>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="create_company_id" class="block text-sm font-medium text-gray-700">Compagnie</label>
                                    <select id="create_company_id" name="company_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Sélectionnez une compagnie</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_country" class="block text-sm font-medium text-gray-700">Pays</label>
                                    <input type="text" name="country" id="create_country" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_city" class="block text-sm font-medium text-gray-700">Ville (optionnelle)</label>
                                    <input type="text" name="city" id="create_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('city')
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
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Modifier la destination</h3>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="edit_company_id" class="block text-sm font-medium text-gray-700">Compagnie</label>
                                    <select id="edit_company_id" name="company_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Sélectionnez une compagnie</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="edit_country" class="block text-sm font-medium text-gray-700">Pays</label>
                                    <input type="text" name="country" id="edit_country" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_city" class="block text-sm font-medium text-gray-700">Ville (optionnelle)</label>
                                    <input type="text" name="city" id="edit_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir supprimer cette destination ? Cette action est irréversible.</p>
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

<!-- Notifications (identique) -->
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
    function openEditModal(id, companyId, country, city) {
        document.getElementById('edit-form').action = `/destinations/${id}`;
        document.getElementById('edit_company_id').value = companyId;
        document.getElementById('edit_country').value = country;
        document.getElementById('edit_city').value = city || '';
        openModal('edit-modal');
    }

    // Configurer la modale de suppression
    function openDeleteModal(id) {
        document.getElementById('delete-form').action = `/destinations/${id}`;
        openModal('delete-modal');
    }
</script>
@endsection
































































