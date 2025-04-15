<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard Financier')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#4f46e5',
          }
        }
      }
    }
  </script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      transition: background-color 0.3s ease;
    }
    .sidebar-transition {
      transition: all 0.3s ease;
    }
  </style>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col">
  <!-- Conteneur principal -->
  <div class="flex flex-col md:flex-row flex-1">
    <!-- Sidebar mobile -->
    <div class="fixed inset-0 z-40 md:hidden hidden" id="mobile-sidebar">
      <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="sidebar-backdrop"></div>
      <div class="relative flex flex-col w-72 max-w-xs bg-white dark:bg-gray-800 h-full shadow-xl sidebar-transition transform -translate-x-full" id="sidebar-content">
        <div class="flex items-center justify-between px-4 py-5 border-b dark:border-gray-700">
          <h2 class="text-lg font-medium text-gray-900 dark:text-white">Menu</h2>
          <button type="button" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300" id="close-sidebar">
            <i class="fas fa-times h-6 w-6"></i>
          </button>
        </div>
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
          <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
            <i class="fas fa-home mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
            Accueil
          </a>
          <a href="{{ route('clients.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
            <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
            Clients
          </a>
          <a href="{{ route('companies.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
            <i class="fas fa-building mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
            Compagnies
          </a>
          <a href="{{ route('destinations.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
            <i class="fas fa-map-marked-alt mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
            Destinations
          </a>
          
          <!-- Bouton de déconnexion dans le sidebar -->
          <div class="px-3 pt-4 pb-2 mt-auto border-t dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-gray-700">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Se déconnecter
              </button>
            </form>
          </div>
        </nav>
      </div>
    </div>

    <!-- Sidebar desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64 border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex items-center h-16 px-4 border-b dark:border-gray-700">
          <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Dashboard Financier</h1>
        </div>
        <nav class="flex-1 flex flex-col overflow-y-auto">
          <div class="px-2 py-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
              <i class="fas fa-home mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
              Accueil
            </a>
            <a href="{{ route('clients.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
              <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
              Clients
            </a>
            <a href="{{ route('companies.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
              <i class="fas fa-building mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
              Compagnies
            </a>
            <a href="{{ route('destinations.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 group">
              <i class="fas fa-map-marked-alt mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300"></i>
              Destinations
            </a>
          </div>
          
          <!-- Profil et déconnexion -->
          <div class="px-3 pt-4 pb-2 mt-auto border-t dark:border-gray-700">
            <div class="flex items-center mb-4">
              <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="Votre photo">
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
              </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-gray-700">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Se déconnecter
              </button>
            </form>
          </div>
        </nav>
      </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header class="bg-white dark:bg-gray-800 shadow-sm z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
          <div class="flex items-center">
            <button class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" id="open-sidebar">
              <i class="fas fa-bars h-5 w-5"></i>
            </button>
            <h1 class="ml-2 text-lg font-semibold text-gray-900 dark:text-white">
              @yield('page-title', 'Bienvenue')
            </h1>
          </div>

          <div class="flex items-center space-x-4">
            <!-- Bouton mode sombre/clair -->
            <button id="theme-toggle" class="p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700">
              <i class="fas fa-moon hidden dark:block"></i>
              <i class="fas fa-sun dark:hidden"></i>
            </button>
            
            <!-- Profil utilisateur -->
            <div class="relative group">
              <button class="flex items-center space-x-2 focus:outline-none">
                <span class="hidden md:inline text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/32" alt="Votre photo">
              </button>
              <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-10 hidden group-hover:block border dark:border-gray-600">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                  <i class="fas fa-user mr-2"></i>Mon profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-gray-600">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Contenu -->
      <main class="flex-1 overflow-y-auto focus:outline-none bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
          <!-- Contenu principal -->
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  <!-- Footer simple -->
  <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
      &copy; {{ date('Y') }} Dashboard Financier. Tous droits réservés.
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    // Gestion du sidebar mobile
    document.addEventListener('DOMContentLoaded', function() {
      const mobileSidebar = document.getElementById('mobile-sidebar');
      const openButton = document.getElementById('open-sidebar');
      const closeButton = document.getElementById('close-sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      const sidebarContent = document.getElementById('sidebar-content');
      
      function openSidebar() {
        mobileSidebar.classList.remove('hidden');
        setTimeout(() => {
          backdrop.classList.add('opacity-75');
          sidebarContent.classList.remove('-translate-x-full');
        }, 10);
      }
      
      function closeSidebar() {
        backdrop.classList.remove('opacity-75');
        sidebarContent.classList.add('-translate-x-full');
        setTimeout(() => {
          mobileSidebar.classList.add('hidden');
        }, 300);
      }
      
      openButton.addEventListener('click', openSidebar);
      closeButton.addEventListener('click', closeSidebar);
      backdrop.addEventListener('click', closeSidebar);
      
      // Gestion du mode sombre
      const themeToggle = document.getElementById('theme-toggle');
      const html = document.documentElement;
      
      themeToggle.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
      });
      
      // Vérifier le thème sauvegardé ou le préférence système
      if (localStorage.getItem('theme') === 'dark' || 
          (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
      }
    });
  </script>
</body>
</html>