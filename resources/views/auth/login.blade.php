<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Nom de l'Application</title>
    <meta name="description" content="Connectez-vous à votre compte pour accéder à vos contenus">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#4f46e5',
                            700: '#4338ca',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon (à personnaliser) -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 sm:max-w-lg md:max-w-xl">
        <!-- Header avec gradient pour plus de modernité -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 py-6 px-8 text-center">
            <div class="flex justify-center mb-3">
                <!-- Logo optionnel -->
                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Bienvenue</h1>
            <p class="text-indigo-100 mt-1">Connectez-vous à votre compte</p>
        </div>

        <!-- Formulaire avec espacement amélioré -->
        <form method="POST" action="{{ route('login') }}" class="p-6 space-y-5 sm:p-8 sm:space-y-6">
            @csrf

            <!-- Affichage des erreurs avec animation -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-3 rounded-md text-sm border border-red-100 animate-[pulse_0.5s_ease-in-out]">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>{{ $errors->first() }}</div>
                    </div>
                </div>
            @endif

            <!-- Champ Email avec validation visuelle -->
            <div class="space-y-1">
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 placeholder-gray-400 transition duration-150 ease-in-out sm:text-sm"
                        placeholder="votre@email.com" value="{{ old('email') }}"
                        aria-describedby="email-help">
                </div>
                <p id="email-help" class="hidden text-xs text-gray-500 mt-1">Format attendu: exemple@domain.com</p>
            </div>

            <!-- Champ Mot de passe avec toggle de visibilité -->
            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-500 transition-colors duration-200">Mot de passe oublié ?</a>
                </div>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 placeholder-gray-400 transition duration-150 ease-in-out sm:text-sm"
                        placeholder="••••••••">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle" aria-label="Afficher le mot de passe">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember me avec meilleur alignement -->
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition duration-150 ease-in-out">
                <label for="remember" class="ml-2 block text-sm text-gray-700 select-none">Se souvenir de moi</label>
            </div>

            <!-- Bouton de soumission avec état de chargement -->
            <div>
                <button type="submit" id="submit-btn"
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200 ease-in-out">
                    <span class="flex items-center">
                        <span id="btn-text">Se connecter</span>
                        <svg id="loading-spinner" class="hidden h-4 w-4 ml-2 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>

            <!-- Séparateur optionnel pour les réseaux sociaux -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-2 bg-white text-sm text-gray-500">Ou continuer avec</span>
                </div>
            </div>

            <!-- Boutons de connexion sociale (optionnel) -->
            <div class="grid grid-cols-2 gap-3">
                <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.342-3.369-1.342-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0110 4.844c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.933.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.14 18.163 20 14.418 20 10c0-5.523-4.477-10-10-10z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-2">GitHub</span>
                </a>
                <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                    </svg>
                    <span class="ml-2">Twitter</span>
                </a>
            </div>
        </form>

        <!-- Footer avec transition au survol -->
        <div class="bg-gray-50 px-6 py-5 text-center border-t border-gray-100 sm:px-8">
            <p class="text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors duration-200">S'inscrire</a>
            </p>
        </div>
    </div>

    <!-- Scripts pour les interactions -->
    <script>
        // Toggle visibilité mot de passe
        document.querySelectorAll('.password-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const passwordInput = button.closest('div').querySelector('input');
                const icon = button.querySelector('svg');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
                } else {
                    passwordInput.type = 'password';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
                }
            });
        });

        // Simulation de chargement au submit
        document.querySelector('form').addEventListener('submit', (e) => {
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('loading-spinner');
            
            submitBtn.disabled = true;
            btnText.textContent = 'Connexion en cours...';
            spinner.classList.remove('hidden');
            
            // Pour la démo, on réinitialise après 2s
            // À remplacer par votre logique de soumission réelle
            setTimeout(() => {
                submitBtn.disabled = false;
                btnText.textContent = 'Se connecter';
                spinner.classList.add('hidden');
            }, 2000);
        });

        // Validation email en temps réel
        document.getElementById('email').addEventListener('input', (e) => {
            const emailHelp = document.getElementById('email-help');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(e.target.value) {
                emailHelp.classList.remove('hidden');
            } else {
                emailHelp.classList.add('hidden');
            }
        });
    </script>
</body>
</html>