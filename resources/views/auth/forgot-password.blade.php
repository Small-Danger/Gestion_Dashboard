<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-indigo-600 py-6 px-8 text-center">
            <h1 class="text-2xl font-bold text-white">Mot de passe oublié ?</h1>
            <p class="text-indigo-100 mt-1">Recevez un lien pour réinitialiser</p>
        </div>

        <!-- Form -->
        <form class="p-8 space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                <input id="email" name="email" type="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="votre@email.com">
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 px-4 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Envoyer le lien
            </button>
        </form>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Retour à la connexion</a>
        </div>
    </div>
</body>
</html>
