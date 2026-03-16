<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Association humanitaire Verre d'eau fraîche</title>
    <link rel="icon" type="image/png" href="{{ asset('Style1/images/logo.png') }}">
    <meta name="description" content="Bienvenue sur le site VEF. Produits, services et témoignages.">
    
    <!-- Fonts -->

    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <header x-data="{ mobileMenuOpen: false }" class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="{{ url('/') }}" class="-m-1.5 p-1.5 transition-transform hover:scale-105">
                    <span class="sr-only">Verre d'eau fraîche</span>
                    <img class="h-12 w-auto" src="{{ asset('Style1/images/logo.png') }}" alt="Logo VEF">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" @click="mobileMenuOpen = true" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 hover:bg-gray-100 transition-colors">
                    <span class="sr-only">Ouvrir le menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-8">
                <a href="{{ url('/#hero') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors">Accueil</a>
                <a href="{{ url('/#about') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors">À propos</a>
                <a href="{{ url('/#services') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors">Nos projets</a>
                <a href="{{ url('/#contact') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors">Contact</a>
                <a href="{{ route('rejoindre') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors">Nous rejoindre</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="{{ route('donation.index') }}" class="rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all hover:shadow-lg hover:-translate-y-0.5">
                    Faire un don <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </nav>
        
        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="lg:hidden" role="dialog" aria-modal="true" x-cloak>
            <div class="fixed inset-0 z-50 bg-black/20 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10 transition-transform duration-300 ease-in-out"
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                <div class="flex items-center justify-between">
                    <a href="{{ url('/') }}" class="-m-1.5 p-1.5">
                        <span class="sr-only">Verre d'eau fraîche</span>
                        <img class="h-10 w-auto" src="{{ asset('Style1/images/logo.png') }}" alt="Logo VEF">
                    </a>
                    <button type="button" @click="mobileMenuOpen = false" class="-m-2.5 rounded-md p-2.5 text-gray-700 hover:bg-gray-100">
                        <span class="sr-only">Fermer le menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="{{ url('/#hero') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" @click="mobileMenuOpen = false">Accueil</a>
                            <a href="{{ url('/#about') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" @click="mobileMenuOpen = false">À propos</a>
                            <a href="{{ url('/#services') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" @click="mobileMenuOpen = false">Nos projets</a>
                            <a href="{{ url('/#contact') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" @click="mobileMenuOpen = false">Contact</a>
                            <a href="{{ route('rejoindre') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" @click="mobileMenuOpen = false">Nous rejoindre</a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('donation.index') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-blue-600 hover:bg-gray-50 text-center border border-blue-100 bg-blue-50" @click="mobileMenuOpen = false">Faire un don</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8">
                    <img class="h-16 w-auto brightness-0 invert opacity-90" src="{{ asset('Style1/images/logo.png') }}" alt="Logo VEF">
                    <p class="text-sm leading-6 text-gray-300 max-w-md">
                        Verre d'eau fraîche, agissons pour chacun, agissons pour tous. ONG reconnue d'intérêt public. L'eau, c'est la vie. Ensemble, partageons-la.
                    </p>
                    <div class="flex space-x-6">
                        <a href="https://www.facebook.com/ONG.VERRE.D.EAU.FRAICHE?locale=fr_FR" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/company/association-humanitaire-verre-d-eau-fraiche/posts/?feedView=all" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Navigation</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li><a href="{{ url('/#hero') }}" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors">Accueil</a></li>
                                <li><a href="{{ url('/#about') }}" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors">À propos</a></li>
                                <li><a href="{{ url('/#services') }}" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors">Nos projets</a></li>
                                <li><a href="{{ route('rejoindre') }}" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors">Nous rejoindre</a></li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Contact</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li class="flex items-start gap-x-3 text-sm leading-6 text-gray-300">
                                    <span class="text-blue-500">📍</span>
                                    <span>Lot 1230, Quartier Fidjrossè,<br>Cotonou, Bénin</span>
                                </li>
                                <li class="flex items-center gap-x-3 text-sm leading-6 text-gray-300">
                                    <span class="text-blue-500">📞</span>
                                    <a href="tel:+22997000000" class="hover:text-white transition-colors">+229 97 00 00 00</a>
                                </li>
                                <li class="flex items-center gap-x-3 text-sm leading-6 text-gray-300">
                                    <span class="text-blue-500">✉️</span>
                                    <a href="mailto:contact@verredeaufraiche.org" class="hover:text-white transition-colors">contact@verredeaufraiche.org</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24">
                <p class="text-xs leading-5 text-gray-400 text-center">&copy; {{ date('Y') }} Verre d'eau fraîche — Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for interactivity -->
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
 