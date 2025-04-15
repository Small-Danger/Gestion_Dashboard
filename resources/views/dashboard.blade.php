@extends('layouts.app')

@section('title', 'Dashboard Financier')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Tableau de Bord</h1>
        <p class="text-sm sm:text-base text-gray-600 mt-1">Aperçu global de votre activité</p>
    </div>

    <!-- Stats Cards - Mobile First Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6 sm:mb-8">
        <!-- Clients Card -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Clients actifs</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['active_clients'] }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('clients.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Voir tous →</a>
            </div>
        </div>

        <!-- Solde Card -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Solde total</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_balance'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('clients.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Voir transactions →</a>
            </div>
        </div>

        <!-- Compagnies Card -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Compagnies</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['companies_count'] }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('companies.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Gérer →</a>
            </div>
        </div>

        <!-- Stock Card -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Stock total</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_stock'], 0, ',', ' ') }} kg</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('companies.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Gérer →</a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Dernières Transactions -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Dernières transactions</h3>
                <p class="mt-1 text-sm text-gray-500">Les 5 dernières opérations</p>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recent_transactions as $transaction)
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $transaction->type === 'deposit' ? 'Versement' : 'Retrait' }} - 
                                {{ $transaction->client->name ?? 'Client supprimé' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <p class="text-sm font-medium {{ $transaction->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                </div>
                @empty
                <div class="px-4 py-4 text-center text-sm text-gray-500">
                    Aucune transaction récente
                </div>
                @endforelse
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <a href="{{ route('clients.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Voir toutes →</a>
            </div>
        </div>

        <!-- Alertes de Stock -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Alertes de stock</h3>
                <p class="mt-1 text-sm text-gray-500">Stocks nécessitant attention</p>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($stock_alerts as $alert)
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $alert->destination->country }} - {{ $alert->destination->company->name }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Stock actuel: {{ $alert->current_stock }} kg
                            </p>
                        </div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Critique
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-4 py-4 text-center text-sm text-gray-500">
                    Aucune alerte de stock
                </div>
                @endforelse
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <a href="{{ route('companies.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Gérer les stocks →</a>
            </div>
        </div>
    </div>
</div>
@endsection