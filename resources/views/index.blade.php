@extends('app')

@section('content')

<!-- Hero Section -->
<section id="hero" class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('Style1/images/better.jpg') }}" alt="Background" class="w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-gray-900/90"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto space-y-8 animate-fade-in-up">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight drop-shadow-lg">
            BIENVENUE À <br>
            <span class="text-blue-400">VERRE D'EAU FRAÎCHE</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-200 font-light max-w-3xl mx-auto">
            "Agissons pour chacun, agissons pour tous."
        </p>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
            Nous œuvrons chaque jour pour améliorer la vie des plus vulnérables à travers l'éducation, la santé et l'autonomisation.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
            <a href="{{ route('rejoindre') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-full transition-all transform hover:scale-105 shadow-lg hover:shadow-blue-500/30">
                Nous rejoindre
            </a>
            <a href="#services" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-gray-900 transition-all transform hover:scale-105">
                Découvrir nos actions
            </a>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#about" class="text-white/70 hover:text-white transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7m7 7V3"></path>
            </svg>
        </a>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">À PROPOS DE NOUS</h2>
            <p class="mt-4 text-lg leading-8 text-gray-600 max-w-2xl mx-auto">
        L’Association humanitaire Verre d’Eau Fraîche est une Association à but non lucratif, une Organisation Non
Gouvernementale, régie par la Constitution du 11 Décembre 1990, la loi du 1er juillet 1901 et son décret
d’application. Elle n’est pas confessionnelle, ni de caractère religieux. Elle est apolitique et n’est d’aucune
appartenance à une confession en particulier.
Verre d’Eau Fraîche regroupe, en son sein, un ensemble de personnes qui adhèrent à venir en aide aux
gens faibles de la société, en particulier les enfants malheureux, les veuves, les jeunes gens, les jeunes filles
et les femmes en difficultés.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Mission -->
            <div class="group p-8 rounded-2xl bg-gray-50 hover:bg-blue-50 transition-colors duration-300 border border-gray-100 hover:border-blue-100">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Notre Mission</h3>
                <p class="text-gray-600 leading-relaxed">
                    Nous existons pour investir dans l’épanouissement, l’éducation ; et l’avenir des personnes les plus faibles et
vulnérables de la société.
                </p>
            </div>

            <!-- Vision -->
            <div class="group p-8 rounded-2xl bg-gray-50 hover:bg-blue-50 transition-colors duration-300 border border-gray-100 hover:border-blue-100">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Notre Vision</h3>
                <p class="text-gray-600 leading-relaxed">
                    Nous rêvons d’être d’ici 2030 la meilleure organisation des jeunes qui agit pour la transformation des
conditions des vies des personne les plus faibles et vulnérables de la société
                </p>
            </div>

            <!-- Values -->
            <div class="group p-8 rounded-2xl bg-gray-50 hover:bg-blue-50 transition-colors duration-300 border border-gray-100 hover:border-blue-100">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Nos Valeurs</h3>
                <p class="text-gray-600 leading-relaxed">
                    Amour, Vertus, Engagement, Noblesse, Integrité, Respect, passion, agir, tolérance, loyauté, défendre, entraide, et intelligence.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section id="services" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">NOS PROJETS EN COURS</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projets as $projet)
            <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset($projet->image) }}" alt="{{ $projet->titre }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-8 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $projet->titre }}</h3>
                    <p class="text-gray-600 mb-6 line-clamp-3 flex-1">{{ $projet->description }}</p>
                    
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors flex items-center gap-2">
                            <span x-text="open ? 'Voir moins' : 'En savoir plus'"></span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-4 text-sm text-gray-500 border-t pt-4">
                            {{ $projet->description_longue }}
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Gallery / Actions Section -->
<section id="gallery" class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">NOS ACTIONS</h2>
                <p class="mt-4 text-lg text-gray-600">Découvrez nos domaines d'intervention prioritaires.</p>
            </div>
            <a href="{{ route('donation.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                Faire un don
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 h-auto md:h-[500px]">
            <!-- Item 1 -->
            <div class="relative group overflow-hidden rounded-2xl h-64 md:h-full md:col-span-2 lg:col-span-1">
                <img src="{{ asset('Style1/images/ecole.jpg') }}" alt="Education" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors duration-300"></div>
                <div class="absolute bottom-0 left-0 p-6 text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-xl font-bold mb-2">Éducation pour tous</h3>
                    <p class="text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Accès à l'éducation pour tous les enfants.</p>
                </div>
            </div>
            
            <!-- Item 2 -->
            <div class="relative group overflow-hidden rounded-2xl h-64 md:h-full md:col-span-2 lg:col-span-2">
                <img src="{{ asset('Style1/images/entrepreneuriat-mots.jpg') }}" alt="Entrepreneuriat" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors duration-300"></div>
                <div class="absolute bottom-0 left-0 p-8 text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold mb-2">Entrepreneuriat</h3>
                    <p class="text-base opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Encourager l'esprit d'initiative à l'endroit des personnes vulnérables.</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="relative group overflow-hidden rounded-2xl h-64 md:h-full md:col-span-1">
                <img src="{{ asset('Style1/images/soins.jpg') }}" alt="Santé" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors duration-300"></div>
                <div class="absolute bottom-0 left-0 p-6 text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-xl font-bold mb-2">Santé</h3>
                    <p class="text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Santé mentale et physique</p>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <<div class="text-center mb-16">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">PRINCIPAUX MOYENS D’ACTION</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mt-6 rounded-full"></div>
        </div>

     Fondée sur une Noblesse d’esprit et une Intégrité absolue, notre mission est de transformer l’Engagement en actes concrets pour le Respect de la dignité humaine. Nous agissons avec Amour au cœur des communautés les plus vulnérables, là où la Passion et l’Entraide deviennent des moteurs de changement.

Notre action ne s'arrête pas au soutien moral : nous bâtissons l’avenir par l'Éducation, en prenant en charge la scolarité et les fournitures des enfants délaissés, et en offrant des formations professionnelles qui redonnent espoir et autonomie. De la santé mentale aux soins physiques urgents, de la lutte contre les violences basées sur le genre à la réinsertion sociale, chaque don de kit alimentaire ou de matériel est une pierre posée pour protéger les plus faibles. Guidés par l’Intelligence collective et une Tolérance infinie, nous parrainons des destins et organisons la solidarité pour que plus personne ne soit laissé au bord du chemin.
<div class="space-y-6">
           <p> 



           </p>
            <a href="{{ url('/#contact') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-all transform hover:scale-105 shadow-lg">
               Vous voulez en savoir plus ? Faîtes vous plaisir !
                
            </a>
        </div>
            </div>
    </div>
</section>

<!-- Volunteer Section -->
<section id="volunteer" class="py-24 bg-blue-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">DEVENEZ BÉNÉVOLE</h2>
            <p class="mt-4 text-lg text-blue-100 max-w-2xl mx-auto">
                Rejoignez notre équipe et participez activement au changement.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/20 transition-all duration-300 text-center group">
                <div class="w-16 h-16 mx-auto bg-blue-500 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🎓</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Stage</h3>
                <p class="text-blue-100 mb-8">Participez à nos programmes éducatifs et contribuez à l'avenir des enfants.</p>
                <a href="{{ route('rejoindre') }}" class="inline-block px-6 py-2 border border-white text-white rounded-full hover:bg-white hover:text-blue-900 transition-colors font-medium">Postuler</a>
            </div>

            <!-- Card 2 -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/20 transition-all duration-300 text-center group">
                <div class="w-16 h-16 mx-auto bg-green-500 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🌍</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Mission</h3>
                <p class="text-blue-100 mb-8">Aidez-nous à apporter des soins de santé aux communautés vulnérables.</p>
                <a href="{{ route('rejoindre') }}" class="inline-block px-6 py-2 border border-white text-white rounded-full hover:bg-white hover:text-blue-900 transition-colors font-medium">Postuler</a>
            </div>

            <!-- Card 3 -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 hover:bg-white/20 transition-all duration-300 text-center group">
                <div class="w-16 h-16 mx-auto bg-purple-500 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🤝</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Service Civique</h3>
                <p class="text-blue-100 mb-8">Soutenez l'autonomisation économique des entrepreneurs locaux.</p>
                <a href="{{ route('rejoindre') }}" class="inline-block px-6 py-2 border border-white text-white rounded-full hover:bg-white hover:text-blue-900 transition-colors font-medium">Postuler</a>
            </div>
        </div>
    </div>
</section>

<!-- Support Section -->
<section id="support" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-12 lg:p-20 flex flex-col justify-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl mb-6">Soutenez-nous</h2>
                    <p class="text-blue-100 text-lg leading-relaxed mb-10">
                        Votre soutien est essentiel pour mener à bien nos missions humanitaires. Chaque contribution, aussi modeste soit-elle, a un impact réel sur la vie des personnes que nous aidons. Ensemble, nous transformons des vies.
                    </p>
                    <div>
                        <a href="{{ route('donation.index') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-full text-blue-700 bg-white hover:bg-gray-50 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Donnez le sourire ❤️
                        </a>
                    </div>
                </div>
                <div class="relative h-64 lg:h-auto">
                    <img src="{{ asset('Style1/images/enfantAide.jpg') }}" alt="Soutien" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-blue-900/20"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact & Map Section -->
<section id="contact" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Map & Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-4">Contactez-nous</h2>
                    <p class="text-gray-600 text-lg">Vous souhaitez devenir bénévole, partenaire ou simplement en savoir plus ?</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Notre adresse</h3>
                                <p class="text-gray-600">Lot 1230, Quartier Fidjrossè, Cotonou, Bénin</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Téléphone</h3>
                                <a href="tel:+22997000000" class="text-gray-600 hover:text-blue-600 transition-colors">+229 97 00 00 00</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                <a href="mailto:contact@verredeaufraiche.org" class="text-gray-600 hover:text-blue-600 transition-colors">contact@verredeaufraiche.org</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100 h-64 lg:h-80">
                    <iframe class="w-full h-full border-0" title="Carte du Bénin" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.openstreetmap.org/export/embed.html?bbox=0.5%2C6.0%2C3.5%2C12.0&layer=mapnik&marker=2.3158%2C6.4969"></iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h3>
                <form method="POST" action="{{ route('message') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                            <input type="text" id="nom" name="nom" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50 focus:bg-white" placeholder="Votre nom">
                        </div>
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                            <input type="text" id="prenom" name="prenom" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50 focus:bg-white" placeholder="Votre prénom">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50 focus:bg-white" placeholder="vous@example.com">
                    </div>

                    <div>
                        <label for="objet" class="block text-sm font-medium text-gray-700 mb-2">Objet</label>
                        <input type="text" id="objet" name="objet" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50 focus:bg-white" placeholder="Sujet de votre message">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50 focus:bg-white" placeholder="Écrivez votre message ici..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-lg transition-all transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
