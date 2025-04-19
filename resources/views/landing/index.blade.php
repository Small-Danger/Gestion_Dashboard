<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowManage | Gestion simplifiée pour votre entreprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        secondary: {
                            600: '#ea580c',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-in-out',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .btn-hover {
            transition: all 0.3s ease;
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
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
            background-color: #2563eb;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .carousel-item {
            display: none;
            animation: fadeIn 0.8s ease-in-out;
        }
        .carousel-item.active {
            display: block;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating {
            animation: float 4s ease-in-out infinite;
        }
        .feature-icon {
            transition: all 0.3s ease;
        }
        .feature-icon:hover {
            transform: rotate(5deg) scale(1.1);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Header avec animation -->
    <header class="sticky top-0 z-50 bg-white shadow-sm animate-fade-in">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo avec animation -->
                <div class="flex items-center animate-scale-in">
                <svg class="h-8 w-8 text-primary-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L3 7L12 12L21 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 12L12 17L21 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 17L12 22L21 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
                    <span class="ml-2 text-xl font-bold text-gray-800">FlowManage</span>
                </div>
                
                <!-- Menu Desktop avec animations -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="#features" class="nav-link text-gray-600 hover:text-primary-600 transition-colors duration-300">Fonctionnalités</a>
                    <a href="#about" class="nav-link text-gray-600 hover:text-primary-600 transition-colors duration-300">À propos</a>
                    <a href="#testimonials" class="nav-link text-gray-600 hover:text-primary-600 transition-colors duration-300">Avis</a>
                    <a href="{{ route('register')}}" class="px-4 py-2 bg-secondary-600 text-white font-medium rounded-md hover:bg-secondary-700 transition-colors duration-300 btn-hover animate-pulse-slow">
                        S'inscrire
                    </a>
                </nav>
                
                <!-- Menu Mobile Button -->
                <button class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 focus:outline-none transition-colors duration-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section avec animations -->
    <section class="py-8 sm:py-12 lg:py-16 overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center">
                <!-- Texte avec animation -->
                <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0 lg:pr-10 animate-slide-up">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                        Maîtrisez votre entreprise <span class="text-primary-600">simplement</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        FlowManage simplifie la gestion de votre inventaire, transactions et rapports pour vous permettre de vous concentrer sur l'essentiel.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="{{ route('register')}}" class="px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition-colors duration-300 btn-hover">
                            Commencer maintenant
                        </a>
                        <a href="#features" class="px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-300 btn-hover">
                            Découvrir les fonctionnalités
                        </a>
                    </div>
                </div>
                
                <!-- Image avec animation -->
                <div class="lg:w-1/2 relative mt-10 lg:mt-0 animate-fade-in">
                    <div class="relative floating">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                             alt="Dashboard FlowManage" 
                             class="w-full h-auto rounded-xl shadow-lg hidden lg:block transform transition duration-500 hover:scale-105">
                        <div class="absolute -right-10 -bottom-10 hidden lg:block animate-slide-up" style="animation-delay: 0.3s;">
                            <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                                 alt="Application mobile" 
                                 class="w-48 h-auto rounded-lg shadow-xl border-4 border-white transform transition duration-500 hover:scale-105">
                        </div>
                        <!-- Version mobile -->
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                             alt="Dashboard FlowManage" 
                             class="w-full h-auto rounded-xl shadow-lg lg:hidden transform transition duration-500 hover:scale-105">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section avec animations -->
    <section id="about" class="py-12 bg-white sm:py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto animate-fade-in" style="animation-delay: 0.2s;">
                <h2 class="text-3xl font-bold text-center text-gray-900">
                    Pourquoi choisir FlowManage ?
                </h2>
                
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Avantage 1 avec animation -->
                    <div class="text-center animate-slide-up" style="animation-delay: 0.3s;">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-50 text-primary-600 feature-icon">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Sécurité optimale</h3>
                        <p class="mt-2 text-gray-600">
                            Vos données sont chiffrées et sauvegardées quotidiennement pour une protection maximale.
                        </p>
                    </div>
                    
                    <!-- Avantage 2 avec animation -->
                    <div class="text-center animate-slide-up" style="animation-delay: 0.4s;">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-50 text-primary-600 feature-icon">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Rapidité d'exécution</h3>
                        <p class="mt-2 text-gray-600">
                            Interface optimisée pour des actions rapides et une productivité accrue.
                        </p>
                    </div>
                    
                    <!-- Avantage 3 avec animation -->
                    <div class="text-center animate-slide-up" style="animation-delay: 0.5s;">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-50 text-primary-600 feature-icon">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Disponible partout</h3>
                        <p class="mt-2 text-gray-600">
                            Accédez à vos données depuis n'importe quel appareil, à tout moment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section avec animations -->
    <section id="features" class="py-12 bg-gray-50 sm:py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12 animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-900">
                    Fonctionnalités clés
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Découvrez comment FlowManage peut transformer votre gestion d'entreprise
                </p>
            </div>
            
            <div class="flex justify-center">
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-6xl">
                    <!-- Feature 1 avec animation -->
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 feature-card animate-slide-up" style="animation-delay: 0.2s;">
                        <div class="flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-br from-primary-600 to-primary-800 text-white mx-auto feature-icon">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900 text-center">Gestion de stocks</h3>
                        <p class="mt-4 text-gray-600 text-center">
                            Suivi en temps réel avec alertes automatiques. Visualisez vos niveaux de stock et optimisez vos commandes.
                        </p>
                    </div>
                    
                    <!-- Feature 2 avec animation -->
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 feature-card animate-slide-up" style="animation-delay: 0.4s;">
                        <div class="flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-br from-primary-600 to-primary-800 text-white mx-auto feature-icon">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900 text-center">Transactions sécurisées</h3>
                        <p class="mt-4 text-gray-600 text-center">
                            Enregistrez et suivez toutes vos transactions financières avec un historique détaillé et des rapports clairs.
                        </p>
                    </div>
                    
                    <!-- Feature 3 avec animation -->
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 feature-card animate-slide-up" style="animation-delay: 0.6s;">
                        <div class="flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-br from-primary-600 to-primary-800 text-white mx-auto feature-icon">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900 text-center">Rapports intelligents</h3>
                        <p class="mt-4 text-gray-600 text-center">
                            Générez automatiquement des rapports personnalisés pour analyser votre activité et prendre les bonnes décisions.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- CTA avec animation -->
            <div class="mt-16 text-center animate-fade-in" style="animation-delay: 0.4s;">
                <a href="{{ route('register')}}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition-all duration-300 btn-hover">
                    Améliorer ma gestion maintenant
                    <svg class="ml-3 -mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
                <p class="mt-4 text-gray-600 animate-fade-in" style="animation-delay: 0.5s;">C'est 100% gratuit, sans engagement</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section avec animations -->
    <section id="testimonials" class="py-12 bg-white sm:py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12 animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-900">
                    Ils nous font confiance
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Découvrez ce que nos clients disent de FlowManage
                </p>
            </div>
            
            <!-- Desktop Version (grid) -->
            <div class="hidden md:grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 avec animation -->
                <div class="bg-gray-50 p-6 rounded-xl transform transition duration-500 hover:scale-105 animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/32.jpg" alt="Marie D.">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Marie D.</h4>
                            <p class="text-gray-600">Gérante boutique</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "FlowManage a révolutionné notre gestion d'inventaire. Les alertes automatiques nous ont fait économiser des milliers d'euros en rupture de stock évitée."
                    </p>
                </div>
                
                <!-- Testimonial 2 avec animation -->
                <div class="bg-gray-50 p-6 rounded-xl transform transition duration-500 hover:scale-105 animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/men/43.jpg" alt="Pierre L.">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Pierre L.</h4>
                            <p class="text-gray-600">Directeur logistique</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "La plateforme est intuitive et puissante. L'intégration avec notre ERP existant s'est faite sans accroc. Un gain de temps considérable."
                    </p>
                </div>
                
                <!-- Testimonial 3 avec animation -->
                <div class="bg-gray-50 p-6 rounded-xl transform transition duration-500 hover:scale-105 animate-slide-up" style="animation-delay: 0.6s;">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sophie T.">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Sophie T.</h4>
                            <p class="text-gray-600">Responsable achats</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Les rapports personnalisés m'ont permis de mieux négocier avec nos fournisseurs. L'application mobile est un vrai plus pour le suivi en déplacement."
                    </p>
                </div>
            </div>
            
            <!-- Mobile Version (carousel) -->
            <div class="md:hidden relative">
                <div class="carousel-item active">
                    <div class="bg-gray-50 p-6 rounded-xl mx-4 transform transition duration-500 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/32.jpg" alt="Marie D.">
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Marie D.</h4>
                                <p class="text-gray-600">Gérante boutique</p>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-600">
                            "FlowManage a révolutionné notre gestion d'inventaire. Les alertes automatiques nous ont fait économiser des milliers d'euros en rupture de stock évitée."
                        </p>
                    </div>
                </div>
                
                <div class="carousel-item">
                    <div class="bg-gray-50 p-6 rounded-xl mx-4 transform transition duration-500 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/men/43.jpg" alt="Pierre L.">
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Pierre L.</h4>
                                <p class="text-gray-600">Directeur logistique</p>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-600">
                            "La plateforme est intuitive et puissante. L'intégration avec notre ERP existant s'est faite sans accroc. Un gain de temps considérable."
                        </p>
                    </div>
                </div>
                
                <div class="carousel-item">
                    <div class="bg-gray-50 p-6 rounded-xl mx-4 transform transition duration-500 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sophie T.">
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Sophie T.</h4>
                                <p class="text-gray-600">Responsable achats</p>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-600">
                            "Les rapports personnalisés m'ont permis de mieux négocier avec nos fournisseurs. L'application mobile est un vrai plus pour le suivi en déplacement."
                        </p>
                    </div>
                </div>
                
                <!-- Carousel Controls -->
                <div class="flex justify-center mt-6 space-x-2">
                    <button class="carousel-control w-3 h-3 rounded-full bg-gray-300 focus:outline-none transition-all duration-300" data-index="0"></button>
                    <button class="carousel-control w-3 h-3 rounded-full bg-gray-300 focus:outline-none transition-all duration-300" data-index="1"></button>
                    <button class="carousel-control w-3 h-3 rounded-full bg-gray-300 focus:outline-none transition-all duration-300" data-index="2"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section avec animation -->
    <section class="py-12 bg-gradient-to-r  sm:py-16 lg:py-20 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray">
                    Prêt à révolutionner votre gestion d'entreprise ?
                </h2>
                <p class="mt-4 text-xl text-gray-600">
                    Créez votre compte gratuitement et commencez dès maintenant.
                </p>
                <div class="mt-8 transform transition duration-500 hover:scale-105 inline-block">
                    <a href="{{ route('register')}}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-gray-60 transition-all duration-300 btn-hover">
                        Créer mon compte gratuit
                        <svg class="ml-3 -mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
                <p class="mt-4 text-sm text-primary-200 animate-fade-in" style="animation-delay: 0.4s;">
                    Aucune carte de crédit requise. Essai gratuit sans limitation.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer avec animation -->
    <footer class="bg-primary-700 text-white animate-fade-in" style="animation-delay: 0.3s;">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center">
                    <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L3 7L12 12L21 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 12L12 17L21 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 17L12 22L21 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
                        <span class="ml-2 text-xl font-bold text-white">FlowManage</span>
                    </div>
                    <p class="mt-4 text-sm text-primary-100">
                        La solution tout-en-un pour la gestion intelligente de vos stocks et transactions.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Navigation</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-primary-100 hover:text-white transition-colors duration-300">Accueil</a></li>
                        <li><a href="#features" class="text-primary-100 hover:text-white transition-colors duration-300">Fonctionnalités</a></li>
                        <li><a href="#about" class="text-primary-100 hover:text-white transition-colors duration-300">À propos</a></li>
                        <li><a href="#testimonials" class="text-primary-100 hover:text-white transition-colors duration-300">Avis</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Légal</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-primary-100 hover:text-white transition-colors duration-300">Mentions légales</a></li>
                        <li><a href="#" class="text-primary-100 hover:text-white transition-colors duration-300">Confidentialité</a></li>
                        <li><a href="#" class="text-primary-100 hover:text-white transition-colors duration-300">CGU</a></li>
                        <li><a href="#" class="text-primary-100 hover:text-white transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-primary-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-primary-100">
                    &copy; 2023 FlowManage. Tous droits réservés.
                </p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-primary-200 hover:text-white transition-colors duration-300 transform hover:scale-110">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="#" class="text-primary-200 hover:text-white transition-colors duration-300 transform hover:scale-110">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-primary-200 hover:text-white transition-colors duration-300 transform hover:scale-110">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu -->
    <div class="hidden fixed inset-0 z-50 bg-white p-4 flex flex-col">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <svg class="h-8 w-8 text-primary-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 5H6C4.895 5 4 5.895 4 7V19C4 20.105 4.895 21 6 21H18C19.105 21 20 20.105 20 19V7C20 5.895 19.105 5 18 5H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 17C13.6569 17 15 15.6569 15 14C15 12.3431 13.6569 11 12 11C10.3431 11 9 12.3431 9 14C9 15.6569 10.3431 17 12 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 5C16 2.79086 14.2091 1 12 1C9.79086 1 8 2.79086 8 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="ml-2 text-xl font-bold text-gray-800">FlowManage</span>
            </div>
            <button class="p-2 rounded-md text-gray-500 hover:text-gray-600 focus:outline-none transition-colors duration-300 close-mobile-menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <nav class="flex-1 space-y-4">
            <a href="#features" class="block py-2 px-4 text-lg font-medium text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-300">Fonctionnalités</a>
            <a href="#about" class="block py-2 px-4 text-lg font-medium text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-300">À propos</a>
            <a href="#testimonials" class="block py-2 px-4 text-lg font-medium text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-300">Avis</a>
            <a href="#" class="block py-2 px-4 text-lg font-medium text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-300">Contact</a>
        </nav>
        
        <div class="mt-auto pt-4 border-t border-gray-200">
            <a href="#" class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition-all duration-300 btn-hover">
                S'inscrire
            </a>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.querySelector('header button').addEventListener('click', function() {
            document.querySelector('.fixed.hidden').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
        
        document.querySelector('.close-mobile-menu').addEventListener('click', function() {
            document.querySelector('.fixed').classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if (this.getAttribute('href') === '#') return;
                
                e.preventDefault();
                
                document.querySelector('.fixed').classList.add('hidden');
                document.body.style.overflow = 'auto';
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Carousel functionality for mobile testimonials
        if (document.querySelector('.carousel-item')) {
            const items = document.querySelectorAll('.carousel-item');
            const controls = document.querySelectorAll('.carousel-control');
            let currentIndex = 0;
            let interval;
            
            function showItem(index) {
                items.forEach(item => item.classList.remove('active'));
                controls.forEach(control => control.classList.remove('bg-primary-600', 'w-4'));
                
                items[index].classList.add('active');
                controls[index].classList.add('bg-primary-600', 'w-4');
                currentIndex = index;
            }
            
            function startCarousel() {
                interval = setInterval(() => {
                    let nextIndex = (currentIndex + 1) % items.length;
                    showItem(nextIndex);
                }, 5000);
            }
            
            controls.forEach(control => {
                control.addEventListener('click', function() {
                    clearInterval(interval);
                    showItem(parseInt(this.getAttribute('data-index')));
                    startCarousel();
                });
            });
            
            // Initialize
            showItem(0);
            startCarousel();
        }
        
        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-fade-in, .animate-slide-up');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Set initial state for animated elements
        document.querySelectorAll('.animate-fade-in').forEach(el => {
            el.style.opacity = '0';
        });
        
        document.querySelectorAll('.animate-slide-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
        });
        
        // Trigger animations when page loads
        window.addEventListener('load', () => {
            animateOnScroll();
        });
        
        // Trigger animations on scroll
        window.addEventListener('scroll', animateOnScroll);
    </script>
</body>
</html>