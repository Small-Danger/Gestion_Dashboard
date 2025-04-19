@extends('layouts.app')

@section('page-title', 'Gestion des Clients')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header avec bouton d'ajout -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <button onclick="document.getElementById('addClientModal').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center w-full sm:w-auto justify-center ">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nouveau Client
        </button>
    </div>

    <!-- Version Mobile -->
    <div class="sm:hidden space-y-4">
        @foreach($clients as $client)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-indigo-600 font-medium">{{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $client->first_name }} {{ $client->last_name }}</h3>
                            <p class="text-xs text-gray-500">{{ $client->phone }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $client->balance >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ number_format($client->balance, 2) }} FCFA
                    </span>
                </div>

                <div class="mt-3 text-sm text-gray-600">
                    <p class="truncate"><span class="font-medium">Adresse:</span> {{ $client->address ?? 'Non renseignée' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Créé le {{ $client->created_at->format('d/m/Y') }}</p>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('clients.transactions.index', ['client' => $client->id]) }}"
                        class="w-full block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm text-center py-2 px-4 rounded-lg shadow transition">
                        <div class="flex justify-center items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Voir Transactions</span>
                            <span class="ml-2 bg-white text-indigo-600 font-bold px-2 py-0.5 rounded-full text-xs">
                                {{ $client->transactions_count ?? $client->transactions()->count() }}
                            </span>
                        </div>
                    </a>


                    <div class="flex space-x-3">
                        <button onclick="openEditModal('{{ $client->id }}', '{{ $client->first_name }}', '{{ $client->last_name }}', '{{ $client->phone }}', '{{ $client->address }}', '{{ $client->balance }}')"
                            class="text-indigo-600 hover:text-indigo-900 text-sm">Modifier</button>

                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Version Desktop -->
    <div class="hidden sm:block bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordonnées</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clients as $client)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-600 font-medium">{{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $client->first_name }} {{ $client->last_name }}</div>
                                    <div class="text-sm text-gray-500">Créé le {{ $client->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $client->phone }}</div>
                            <div class="text-sm text-gray-500">{{ $client->address ?? 'Non renseignée' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $client->balance >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ number_format($client->balance, 2) }} FCFA
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button onclick="openEditModal('{{ $client->id }}', '{{ $client->first_name }}', '{{ $client->last_name }}', '{{ $client->phone }}', '{{ $client->address }}', '{{ $client->balance }}')"
                                class="text-indigo-600 hover:text-indigo-900">Modifier</button>

                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client?')">Supprimer</button>
                            </form>
                            <a href="{{ route('clients.transactions.index', ['client' => $client->id]) }}"
                                class="inline-flex items-center px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Transactions</span>
                                <span class="ml-2 bg-white text-indigo-600 font-bold px-2 py-0.5 rounded-full text-xs">
                                    {{ $client->transactions_count ?? $client->transactions()->count() }}
                                </span>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            {{ $clients->links() }}
        </div>
    </div>
</div>

<!-- Modal d'ajout - Version responsive -->
<div id="addClientModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-2 sm:mx-0">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Ajouter un nouveau client</h3>
            <button onclick="document.getElementById('addClientModal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="px-4 sm:px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom *</label>
                        <input type="text" name="first_name" id="first_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" name="last_name" id="last_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                    <input type="text" name="phone" id="phone" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea name="address" id="address" rows="2"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <div>
                    <label for="balance" class="block text-sm font-medium text-gray-700">Solde initial (FCFA)</label>
                    <input type="number" step="0.01" name="balance" id="balance" value="0"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('addClientModal').classList.add('hidden')"
                    class="btn-secondary px-4 py-2 text-sm">
                    Annuler
                </button>
                <button type="submit" class="btn-primary px-4 py-2 text-sm">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal d'édition - Version responsive -->
<div id="editClientModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-2 sm:mx-0">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Modifier le client</h3>
            <button onclick="document.getElementById('editClientModal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="px-4 sm:px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_first_name" class="block text-sm font-medium text-gray-700">Prénom *</label>
                        <input type="text" name="first_name" id="edit_first_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="edit_last_name" class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" name="last_name" id="edit_last_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="edit_phone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                    <input type="text" name="phone" id="edit_phone" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="edit_address" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea name="address" id="edit_address" rows="2"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <div>
                    <label for="edit_balance" class="block text-sm font-medium text-gray-700">Solde (FCFA)</label>
                    <input type="number" step="0.01" name="balance" id="edit_balance"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('editClientModal').classList.add('hidden')"
                    class="btn-secondary px-4 py-2 text-sm">
                    Annuler
                </button>
                <button type="submit" class="btn-primary px-4 py-2 text-sm">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, firstName, lastName, phone, address, balance) {
        document.getElementById('editForm').action = `/clients/${id}`;
        document.getElementById('edit_first_name').value = firstName;
        document.getElementById('edit_last_name').value = lastName;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_address').value = address || '';
        document.getElementById('edit_balance').value = balance;
        document.getElementById('editClientModal').classList.remove('hidden');
    }

    // Fermer les modales avec la touche ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('addClientModal').classList.add('hidden');
            document.getElementById('editClientModal').classList.add('hidden');
        }
    });
</script>
@endsection