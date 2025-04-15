@extends('layouts.app')

@section('title', 'Gestion des Transactions')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- En-tête mobile first -->
    <div class="mb-6 bg-white shadow rounded-lg p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Transactions de {{ $client->first_name }} {{ $client->last_name }}</h2>
                <p class="text-sm text-gray-500">Historique des opérations financières</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-500">Solde actuel</p>
                <p class="text-xl sm:text-2xl font-semibold {{ $client->balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($client->balance, 2) }} FCFA
                </p>
            </div>
        </div>
    </div>

    <!-- Filtres et bouton d'ajout -->
    <div class="mb-4 bg-white shadow rounded-lg p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <!-- Filtres -->
            <div class="w-full sm:w-auto grid grid-cols-2 sm:flex gap-2 sm:gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <label for="filter-type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select id="filter-type" class="filter-select">
                        <option value="all">Tous</option>
                        <option value="deposit">Versements</option>
                        <option value="withdrawal">Retraits</option>
                    </select>
                </div>
                <div>
                    <label for="filter-date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <select id="filter-date" class="filter-select">
                        <option value="all">Toutes</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                    </select>
                </div>
                <div>
                    <label for="filter-amount" class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                    <select id="filter-amount" class="filter-select">
                        <option value="all">Tous</option>
                        <option value="0-5000">0 - 5 000 FCFA</option>
                        <option value="5000-10000">5 000 - 10 000 FCFA</option>
                        <option value="10000+">10 000+ FCFA</option>
                    </select>
                </div>
            </div>
            
            <!-- Bouton d'ajout -->
            <button onclick="document.getElementById('addTransactionModal').classList.remove('hidden')" 
                    class="btn-primary flex items-center justify-center w-full sm:w-auto mt-2 sm:mt-0">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle transaction
            </button>
        </div>
    </div>

    <!-- Version Mobile - Liste des transactions -->
    <div class="sm:hidden space-y-4">
        @forelse($client->transactions as $transaction)
        <div class="bg-white shadow rounded-lg overflow-hidden transaction-card" 
             data-type="{{ $transaction->type }}"
             data-date="{{ $transaction->transaction_date->format('Y-m-d') }}"
             data-amount="{{ $transaction->amount }}">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                          {{ $transaction->type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $transaction->type === 'deposit' ? 'Versement' : 'Retrait' }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-sm font-medium {{ $transaction->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->type === 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} FCFA
                    </span>
                    <p class="text-xs text-gray-500">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <div class="p-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Solde avant</p>
                        <p>{{ number_format($transaction->balance_before, 2) }} FCFA</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Solde après</p>
                        <p class="font-medium">{{ number_format($transaction->balance_after, 2) }} FCFA</p>
                    </div>
                </div>
                
                @if($transaction->notes)
                <div class="mt-3">
                    <p class="text-gray-500 text-sm">Notes</p>
                    <p class="text-sm">{{ $transaction->notes }}</p>
                </div>
                @endif
                
                <div class="mt-4 flex justify-end space-x-3">
                    <button onclick="openEditModal(
                        '{{ route('clients.transactions.update', [$client->id, $transaction->id]) }}',
                        '{{ $transaction->type }}',
                        '{{ $transaction->amount }}',
                        `{{ $transaction->notes ?? '' }}`
                    )" class="text-indigo-600 hover:text-indigo-900 text-sm">Modifier</button>
                    
                    <form action="{{ route('clients.transactions.destroy', [$client->id, $transaction->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette transaction?')">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
            Aucune transaction disponible.
        </div>
        @endforelse
    </div>

    <!-- Version Desktop - Tableau des transactions -->
    <div class="hidden sm:block bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde avant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde après</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($client->transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors transaction-row"
                        data-type="{{ $transaction->type }}"
                        data-date="{{ $transaction->transaction_date->format('Y-m-d') }}"
                        data-amount="{{ $transaction->amount }}">
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $transaction->transaction_date->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $transaction->type === 'deposit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $transaction->type === 'deposit' ? 'Versement' : 'Retrait' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium 
                            {{ $transaction->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($transaction->balance_before, 2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ number_format($transaction->balance_after, 2) }} FCFA
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                            {{ $transaction->notes ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button onclick="openEditModal(
                                '{{ route('clients.transactions.update', [$client->id, $transaction->id]) }}',
                                '{{ $transaction->type }}',
                                '{{ $transaction->amount }}',
                                `{{ $transaction->notes ?? '' }}`
                            )" class="text-indigo-600 hover:text-indigo-900">Modifier</button>
                            <form action="{{ route('clients.transactions.destroy', [$client->id, $transaction->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette transaction?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 text-sm">Aucune transaction disponible.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
    <div class="mt-4 bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            {{ $transactions->links() }}
        </div>
    </div>
@endif

</div>

<!-- Modal ajout transaction - Version responsive -->
<div id="addTransactionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-2 sm:mx-0">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Nouvelle transaction</h3>
            <button onclick="document.getElementById('addTransactionModal').classList.add('hidden')" 
                    class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('clients.transactions.store', $client->id) }}" method="POST">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <div class="px-4 sm:px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type de transaction *</label>
                    <div class="mt-1 grid grid-cols-2 gap-3">
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="deposit" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2">Versement</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="withdrawal" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2">Retrait</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Montant (FCFA) *</label>
                    <input type="number" step="0.01" min="0.01" name="amount" id="amount" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>
                @if($errors->has('duplicate'))
                    <div class="text-red-600 text-sm">{{ $errors->first('duplicate') }}</div>
                @endif
            </div>
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('addTransactionModal').classList.add('hidden')" 
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

<!-- Modal modification - Version responsive -->
<div id="editTransactionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-2 sm:mx-0">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Modifier la transaction</h3>
            <button onclick="document.getElementById('editTransactionModal').classList.add('hidden')" 
                    class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="editTransactionForm" method="POST">
            @csrf
            @method('PUT')
            <div class="px-4 sm:px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type de transaction *</label>
                    <div class="mt-1 grid grid-cols-2 gap-3">
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="deposit" id="edit_type_deposit" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2">Versement</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="withdrawal" id="edit_type_withdrawal" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2">Retrait</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label for="edit_amount" class="block text-sm font-medium text-gray-700">Montant (FCFA) *</label>
                    <input type="number" step="0.01" min="0.01" name="amount" id="edit_amount" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="edit_notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                    <textarea name="notes" id="edit_notes" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>
            </div>
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('editTransactionModal').classList.add('hidden')" 
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
// Fonction pour ouvrir la modal d'édition
function openEditModal(actionUrl, type, amount, notes) {
    document.getElementById('editTransactionForm').action = actionUrl;
    document.getElementById('edit_amount').value = amount;
    document.getElementById('edit_notes').value = notes || '';
    document.getElementById(type === 'deposit' ? 'edit_type_deposit' : 'edit_type_withdrawal').checked = true;
    document.getElementById('editTransactionModal').classList.remove('hidden');
}

// Filtrage des transactions
document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('filter-type');
    const filterDate = document.getElementById('filter-date');
    const filterAmount = document.getElementById('filter-amount');
    
    function applyFilters() {
        const typeValue = filterType.value;
        const dateValue = filterDate.value;
        const amountValue = filterAmount.value;
        
        // Filtrer les cartes mobile
        document.querySelectorAll('.transaction-card').forEach(card => {
            const cardType = card.dataset.type;
            const cardDate = card.dataset.date;
            const cardAmount = parseFloat(card.dataset.amount);
            
            let typeMatch = typeValue === 'all' || cardType === typeValue;
            let dateMatch = dateValue === 'all' || checkDateMatch(cardDate, dateValue);
            let amountMatch = amountValue === 'all' || checkAmountMatch(cardAmount, amountValue);
            
            card.style.display = (typeMatch && dateMatch && amountMatch) ? 'block' : 'none';
        });
        
        // Filtrer les lignes du tableau desktop
        document.querySelectorAll('.transaction-row').forEach(row => {
            const rowType = row.dataset.type;
            const rowDate = row.dataset.date;
            const rowAmount = parseFloat(row.dataset.amount);
            
            let typeMatch = typeValue === 'all' || rowType === typeValue;
            let dateMatch = dateValue === 'all' || checkDateMatch(rowDate, dateValue);
            let amountMatch = amountValue === 'all' || checkAmountMatch(rowAmount, amountValue);
            
            row.style.display = (typeMatch && dateMatch && amountMatch) ? 'table-row' : 'none';
        });
    }
    
    function checkDateMatch(dateString, filterValue) {
        const today = new Date();
        const date = new Date(dateString);
        
        switch(filterValue) {
            case 'today':
                return date.toDateString() === today.toDateString();
            case 'week':
                const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                return date >= startOfWeek;
            case 'month':
                return date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear();
            default:
                return true;
        }
    }
    
    function checkAmountMatch(amount, filterValue) {
        switch(filterValue) {
            case '0-5000':
                return amount >= 0 && amount <= 5000;
            case '5000-10000':
                return amount > 5000 && amount <= 10000;
            case '10000+':
                return amount > 10000;
            default:
                return true;
        }
    }
    
    // Écouteurs d'événements pour les filtres
    filterType.addEventListener('change', applyFilters);
    filterDate.addEventListener('change', applyFilters);
    filterAmount.addEventListener('change', applyFilters);
    
    // Fermer les modales avec ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('addTransactionModal').classList.add('hidden');
            document.getElementById('editTransactionModal').classList.add('hidden');
        }
    });
});
</script>

<style>
.filter-select {
    @apply mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md;
}

.btn-primary {
    @apply inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}

.btn-secondary {
    @apply inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}
</style>
@endsection