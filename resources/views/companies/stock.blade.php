@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Stocks pour {{ $company->name }}</h1>
            <div class="flex items-center mt-1 sm:mt-2">
                <a href="{{ route('companies.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center text-sm sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux compagnies
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-600 text-sm sm:text-base">Gestion des stocks</span>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 sm:space-x-4">
            <div class="bg-blue-100 text-blue-800 px-3 py-1 sm:px-4 sm:py-2 rounded-lg text-sm sm:text-base">
                Stock total: <span class="font-bold">{{ $company->currentStock() }}</span>
            </div>
            <button onclick="openModal('add-stock-modal')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-lg flex items-center text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajouter Stock
            </button>
        </div>
    </div>

    <!-- Tableau des destinations - Version Mobile (Cards) -->
    <div class="sm:hidden bg-white rounded-lg shadow overflow-hidden mb-6">
        @forelse($destinations as $destination)
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <div class="font-medium text-gray-900">
                        {{ $destination->country }}
                        @if($destination->city)
                            - {{ $destination->city }}
                        @endif
                    </div>
                    <div class="mt-1 flex items-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $destination->currentStock() > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            Stock: {{ $destination->currentStock() }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('destinations.index', $destination) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
            </div>
            @if($destination->lastMovement())
                <div class="mt-2 text-xs text-gray-500">
                    Dernier mouvement: {{ $destination->lastMovement()->created_at->diffForHumans() }}
                    ({{ $destination->lastMovement()->type === 'in' ? 'Entrée' : 'Sortie' }} de {{ $destination->lastMovement()->quantity }})
                </div>
            @else
                <div class="mt-2 text-xs text-gray-500">Aucun mouvement</div>
            @endif
        </div>
        @empty
        <div class="p-4 text-center text-sm text-gray-500">Aucune destination trouvée</div>
        @endforelse
        <!-- Pagination Mobile -->
        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $destinations->links() }}
        </div>
    </div>

    <!-- Tableau des destinations - Version Desktop -->
    <div class="hidden sm:block bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock actuel</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernier mouvement</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($destinations as $destination)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $destination->country }}
                                @if($destination->city)
                                    - {{ $destination->city }}
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $destination->currentStock() > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $destination->currentStock() }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($destination->lastMovement())
                                <div class="text-sm text-gray-900">
                                    {{ $destination->lastMovement()->created_at->diffForHumans() }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $destination->lastMovement()->type === 'in' ? 'Entrée' : 'Sortie' }} de {{ $destination->lastMovement()->quantity }}
                                </div>
                            @else
                                <div class="text-sm text-gray-500">Aucun mouvement</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('destinations.index', $destination) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Détails
                            </a>
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

    <!-- Tableau des mouvements -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Historique des mouvements</h3>
            <div class="mt-2 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <p class="text-sm text-gray-500">Tous les mouvements de stock pour cette compagnie</p>
                <form method="GET" class="w-full sm:w-auto">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <label for="destination_filter" class="block text-sm text-gray-600 sm:mr-2">Filtrer par destination:</label>
                        <select id="destination_filter" name="destination_id" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">Toutes</option>
                            @foreach($company->destinations as $dest)
                                <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                                    {{ $dest->country }}@if($dest->city) - {{ $dest->city }}@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Version Mobile - Mouvements -->
        <div class="sm:hidden">
            @forelse($movements as $movement)
            <div class="p-4 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-medium text-gray-900">
                            {{ $movement->destination->country }}
                            @if($movement->destination->city)
                                - {{ $movement->destination->city }}
                            @endif
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            {{ $movement->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $movement->type === 'in' ? 'Entrée' : 'Sortie' }}
                    </span>
                </div>
                <div class="mt-2 grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-600">Quantité:</span>
                        <span class="font-medium">{{ $movement->quantity }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Stock après:</span>
                        <span class="font-medium">{{ $movement->remaining }}</span>
                    </div>
                </div>
                @if($movement->notes)
                <div class="mt-2 text-sm">
                    <span class="text-gray-600">Notes:</span>
                    <p class="text-gray-500 truncate">{{ $movement->notes }}</p>
                </div>
                @endif
                <div class="mt-3 flex justify-end space-x-3 text-sm">
                    <button onclick="openEditMovementModal({{ $movement->id }}, '{{ $movement->type }}', {{ $movement->quantity }}, `{{ $movement->notes }}`, {{ $movement->destination_id }})" 
                            class="text-blue-600 hover:text-blue-900">Modifier</button>
                    <form action="{{ route('stock.destroy', $movement) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement?')">Supprimer</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-sm text-gray-500">Aucun mouvement trouvé</div>
            @endforelse
        </div>
        
        <!-- Version Desktop - Mouvements -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock après</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movements as $movement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $movement->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $movement->destination->country }}
                                @if($movement->destination->city)
                                    - {{ $movement->destination->city }}
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($movement->type === 'in')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Entrée
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Sortie
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $movement->quantity }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $movement->remaining }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-500 max-w-xs truncate">{{ $movement->notes ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openEditMovementModal({{ $movement->id }}, '{{ $movement->type }}', {{ $movement->quantity }}, `{{ $movement->notes }}`, {{ $movement->destination_id }})" 
                                    class="text-blue-600 hover:text-blue-900 mr-3">Modifier</button>
                            <form action="{{ route('stock.destroy', $movement) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Aucun mouvement trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $movements->links() }}
        </div>
    </div>
</div>

<!-- Modale d'ajout de stock -->
<div id="add-stock-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" onclick="closeModal('add-stock-modal')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('companies.stock.store', $company) }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ajouter un mouvement de stock</h3>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination *</label>
                                    <select id="destination_id" name="destination_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @foreach($company->destinations as $destination)
                                            <option value="{{ $destination->id }}">
                                                {{ $destination->country }}@if($destination->city) - {{ $destination->city }}@endif
                                                (Stock: {{ $destination->currentStock() }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type de mouvement *</label>
                                    <div class="mt-2 flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="type" value="in" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-gray-700">Entrée</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="type" value="out" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-gray-700">Sortie</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantité *</label>
                                    <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal('add-stock-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modale de modification de mouvement -->
<div id="edit-movement-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" onclick="closeModal('edit-movement-modal')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="edit-movement-form" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Modifier le mouvement de stock</h3>
                            <div class="mt-2 space-y-4">
                                <div>
                                    <label for="edit_destination_id" class="block text-sm font-medium text-gray-700">Destination *</label>
                                    <select id="edit_destination_id" name="destination_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @foreach($company->destinations as $destination)
                                            <option value="{{ $destination->id }}">
                                                {{ $destination->country }}@if($destination->city) - {{ $destination->city }}@endif
                                                (Stock: {{ $destination->currentStock() }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type de mouvement *</label>
                                    <div class="mt-2 flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="type" value="in" id="edit_type_in" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-gray-700">Entrée</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="type" value="out" id="edit_type_out" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="ml-2 text-gray-700">Sortie</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label for="edit_quantity" class="block text-sm font-medium text-gray-700">Quantité *</label>
                                    <input type="number" step="0.01" min="0.01" name="quantity" id="edit_quantity" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="edit_notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea name="notes" id="edit_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mettre à jour
                    </button>
                    <button type="button" onclick="closeModal('edit-movement-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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

    // Pré-remplir et ouvrir la modale d'édition de mouvement
    function openEditMovementModal(id, type, quantity, notes, destinationId) {
        document.getElementById('edit-movement-form').action = `/stock/${id}`;
        document.getElementById('edit_destination_id').value = destinationId;
        document.getElementById(`edit_type_${type}`).checked = true;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_notes').value = notes || '';
        openModal('edit-movement-modal');
    }

    // Validation pour les sorties de stock
    document.addEventListener('DOMContentLoaded', function() {
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const quantityInput = document.getElementById('quantity');
        
        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'out') {
                    const destinationId = document.getElementById('destination_id').value;
                    // Ici vous pourriez faire une requête AJAX pour obtenir le stock actuel
                    // et définir la valeur max du champ quantité
                } else {
                    quantityInput.removeAttribute('max');
                }
            });
        });
    });
</script>
@endsection