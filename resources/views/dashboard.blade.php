@extends('layouts.app')

@section('page-title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Titre principal -->
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        Résumé de votre activité
    </h2>

    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Carte Clients -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Clients actifs</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['active_clients'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <a href="{{ route('clients.index') }}" class="mt-4 inline-block text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                Voir tous les clients →
            </a>
        </div>

        <!-- Carte Solde -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Solde total</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_balance'], 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
            <a href="{{ route('clients.index') }}" class="mt-4 inline-block text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                Voir les transactions →
            </a>
        </div>

        <!-- Carte Compagnies -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Compagnies</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['companies_count'] }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                    <i class="fas fa-building text-xl"></i>
                </div>
            </div>
            <a href="{{ route('companies.index') }}" class="mt-4 inline-block text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                Gérer les compagnies →
            </a>
        </div>

        <!-- Carte Stock -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock total</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_stock'], 0, ',', ' ') }} kg</p>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                    <i class="fas fa-boxes text-xl"></i>
                </div>
            </div>
            <a href="{{ route('companies.index') }}" class="mt-4 inline-block text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                Voir les mouvements →
            </a>
        </div>
    </div>

    <!-- Sections principales -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Dernières Transactions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-5 py-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Dernières transactions</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Les 5 dernières opérations enregistrées</p>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recent_transactions as $transaction)
                <div class="px-5 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $transaction->client->name ?? 'Client supprimé' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $transaction->created_at->format('d/m/Y H:i') }} - 
                                {{ $transaction->type === 'deposit' ? 'Versement' : 'Retrait' }}
                            </p>
                        </div>
                        <span class="font-medium {{ $transaction->type === 'deposit' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $transaction->type === 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                    Aucune transaction récente
                </div>
                @endforelse
            </div>
            <div class="px-5 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('clients.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                    Voir toutes les transactions →
                </a>
            </div>
        </div>

        <!-- Derniers Mouvements de Stock -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-5 py-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Derniers mouvements</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Les 5 derniers mouvements de stock</p>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recent_stock_movements as $movement)
                <div class="px-5 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $movement->destination->company->name ?? 'Compagnie inconnue' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $movement->created_at->format('d/m/Y H:i') }} - 
                                {{ $movement->quantity }} kg
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $movement->remaining < 50 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                            {{ $movement->remaining }} kg restant
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                    Aucun mouvement de stock récent
                </div>
                @endforelse
            </div>
            <div class="px-5 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('companies.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                    Voir tous les mouvements →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection