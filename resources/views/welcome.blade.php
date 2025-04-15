<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Financier</title>
  <!-- Lien vers Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen bg-gray-50">
  <!-- Header -->
  <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <button class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100">
        <!-- Menu icon -->
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <h1 class="text-xl font-semibold text-gray-800">Dashboard Financier</h1>
      <div class="flex items-center space-x-4">
        <button class="p-2 rounded-full text-gray-500 hover:text-gray-600 hover:bg-gray-100">
          <!-- Notification icon -->
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>
        <div class="relative">
          <button class="flex items-center space-x-2 focus:outline-none">
            <span class="text-sm font-medium text-gray-700">Admin</span>
            <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/32" alt="Profile">
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
      <!-- Clients Card -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Clients actifs</dt>
                <dd class="flex items-baseline">
                  <div class="text-2xl font-semibold text-gray-900">1,234</div>
                  <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Increased by</span>12%
                  </div>
                </dd>
              </dl>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="/clients" class="font-medium text-indigo-600 hover:text-indigo-500">Voir tous les clients<span class="sr-only">Total clients stats</span></a>
          </div>
        </div>
      </div>

      <!-- Solde Total Card -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Solde total</dt>
                <dd class="flex items-baseline">
                  <div class="text-2xl font-semibold text-gray-900">12,345,000 FCFA</div>
                </dd>
              </dl>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="/transactions" class="font-medium text-indigo-600 hover:text-indigo-500">Voir les transactions<span class="sr-only">Solde total stats</span></a>
          </div>
        </div>
      </div>

      <!-- Compagnies Card -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Compagnies</dt>
                <dd class="flex items-baseline">
                  <div class="text-2xl font-semibold text-gray-900">15</div>
                </dd>
              </dl>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="/compagnies" class="font-medium text-indigo-600 hover:text-indigo-500">Gérer les compagnies<span class="sr-only">Total compagnies stats</span></a>
          </div>
        </div>
      </div>

      <!-- Stock Total Card -->
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Stock total</dt>
                <dd class="flex items-baseline">
                  <div class="text-2xl font-semibold text-gray-900">1,234 kg</div>
                <div class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
                  <svg class="self-center flex-shrink-0 h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">Decreased by</span>5%
                </div>
              </dd>
            </dl>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <div class="text-sm">
          <a href="/stocks" class="font-medium text-indigo-600 hover:text-indigo-500">Gérer les stocks<span class="sr-only">Total stock stats</span></a>
        </div>
      </div>
    </div>

    <!-- Recent Activity & Stock Overview -->
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
      <!-- Recent Transactions -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Dernières transactions</h3>
          <p class="mt-1 text-sm text-gray-500">Les 5 dernières opérations financières</p>
        </div>
        <div class="bg-white overflow-hidden">
          <ul class="divide-y divide-gray-200">
            <li class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-green-100 rounded-md p-2">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Versement</p>
                    <p class="text-sm text-gray-500">Client: Jean Dupont</p>
                  </div>
                </div>
                <div class="ml-2 flex flex-shrink-0">
                  <p class="text-sm font-medium text-green-600">+25,000 FCFA</p>
                </div>
              </div>
            </li>
            <!-- More transactions... -->
          </ul>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="/transactions" class="font-medium text-indigo-600 hover:text-indigo-500">Voir toutes les transactions<span class="sr-only">View all transactions</span></a>
          </div>
        </div>
      </div>

      <!-- Stock Alerts -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Alertes de stock</h3>
          <p class="mt-1 text-sm text-gray-500">Stocks critiques à réapprovisionner</p>
        </div>
        <div class="bg-white overflow-hidden">
          <ul class="divide-y divide-gray-200">
            <li class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-red-100 rounded-md p-2">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Mali</p>
                    <p class="text-sm text-gray-500">DHL - Stock restant: 5kg</p>
                  </div>
                </div>
                <div class="ml-2 flex flex-shrink-0">
                  <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Réappro.
                  </button>
                </div>
              </div>
            </li>
            <!-- More alerts... -->
          </ul>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="/stocks" class="font-medium text-indigo-600 hover:text-indigo-500">Voir tous les stocks<span class="sr-only">View all stocks</span></a>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>