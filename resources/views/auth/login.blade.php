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
                        facebook: {
                            600: '#1877f2',
                        }
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
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 sm:max-w-lg md:max-w-xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 py-6 px-8 text-center">
            <div class="flex justify-center mb-3">
                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Bienvenue</h1>
            <p class="text-indigo-100 mt-1">Connectez-vous à votre compte</p>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}" class="p-6 space-y-5 sm:p-8 sm:space-y-6">
            @csrf

            <!-- Affichage des erreurs -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-3 rounded-md text-sm border border-red-100">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>{{ $errors->first() }}</div>
                    </div>
                </div>
            @endif

            <!-- Champ Email -->
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
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 placeholder-gray-400"
                        placeholder="votre@email.com" value="{{ old('email') }}">
                </div>
            </div>

            <!-- Champ Mot de passe -->
            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-500">Mot de passe oublié ?</a>
                </div>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600"
                        placeholder="••••••••">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePasswordVisibility()">
                        <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" checked
                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Se souvenir de moi</label>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Se connecter
            </button>

            <!-- Séparateur -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-2 bg-white text-sm text-gray-500">Ou continuer avec</span>
                </div>
            </div>

            <!-- Bouton Facebook -->
            <a href="#" class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-facebook-600 text-white hover:bg-facebook-700">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.978 20 15.991 20 10z" clip-rule="evenodd"/>
                </svg>
                <span>Facebook</span>
            </a>
        </form>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-5 text-center border-t border-gray-100 sm:px-8">
            <p class="text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500">S'inscrire</a>
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle visibilité mot de passe
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        // Validation email en temps réel
        document.getElementById('email').addEventListener('input', (e) => {
            const emailHelp = document.getElementById('email-help');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(e.target.value)) {
                if (emailHelp) emailHelp.classList.remove('hidden');
            } else {
                if (emailHelp) emailHelp.classList.add('hidden');
            }
        });
    </script>
</body>
</html>