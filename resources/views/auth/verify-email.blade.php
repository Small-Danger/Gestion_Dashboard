<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de l’email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-inter">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-xl font-semibold text-center text-indigo-600 mb-4">Vérifiez votre adresse e-mail</h2>
        <p class="text-sm text-gray-600 mb-6 text-center">
            Un lien de vérification a été envoyé à votre adresse email.
            Si vous ne l’avez pas reçu, vous pouvez demander un nouveau lien.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="text-center">
            @csrf
            <button type="submit"
                class="w-full py-3 px-4 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Renvoyer le lien de vérification
            </button>
        </form>

        <div class="text-center mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</body>
</html>
