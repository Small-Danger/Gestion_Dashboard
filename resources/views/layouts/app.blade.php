<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Tableau de Bord')</title>
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
    .btn-primary {
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .nav-link {
      position: relative;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 0;
      background-color: #4f46e5;
      transition: width 0.3s ease;
    }
    .nav-link:hover::after {
      width: 100%;
    }
  </style>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col">
  <!-- Header principal -->
  <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center">
        <!-- Logo et titre -->
        <div class="flex items-center">
          <svg class="h-8 w-8 text-primary-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L3 7L12 12L21 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 12L12 17L21 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 17L12 22L21 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <h1 class="ml-2 text-xl font-bold text-gray-900 dark:text-white">FlowManage</h1>
        </div>

        <!-- Navigation principale -->
        <nav class=" md:flex space-x-6 items-center">
        <a href="{{ route('dashboard') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium">
            <i class="fas fa-home mr-1"></i> Accueil
          </a>
        </nav>

        <!-- Contrôles utilisateur -->
        <div class="flex items-center space-x-4">
          <!-- Bouton mode sombre/clair -->
          <button id="theme-toggle" class="p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-moon hidden dark:block"></i>
            <i class="fas fa-sun dark:hidden"></i>
          </button>
          
          <!-- Menu profil -->
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

      <!-- Boutons d'action principaux (en dessous du header) -->
      <div class="mt-4 flex flex-wrap gap-3">
        <a href="{{ route('clients.index') }}" class="btn-primary flex-1 md:flex-none px-4 py-2 bg-primary text-white font-medium rounded-md shadow hover:bg-primary-700 flex items-center justify-center">
          <i class="fas fa-users mr-2"></i> Gérer les Clients
        </a>
        <a href="{{ route('companies.index') }}" class="btn-primary flex-1 md:flex-none px-4 py-2 bg-primary text-white font-medium rounded-md shadow hover:bg-primary-700 flex items-center justify-center">
          <i class="fas fa-building mr-2"></i> Gérer les Compagnies
        </a>
      </div>
    </div>
  </header>

  <!-- Contenu principal -->
  <main class="flex-1 overflow-y-auto focus:outline-none bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
      <!-- Titre de la page -->
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        @yield('page-title')
      </h2>



      <!-- Contenu spécifique à la page -->
      @yield('content')
    </div>
  </main>

  <!-- Footer simple -->
  <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
      &copy; {{ date('Y') }} FlowManage V2. Tous droits réservés.
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    // Gestion du mode sombre
    document.addEventListener('DOMContentLoaded', function() {
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