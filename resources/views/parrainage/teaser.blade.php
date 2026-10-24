@if($programmesParrainage->isNotEmpty())
    <section class="bg-blue-50 py-20" aria-labelledby="parrainage-accueil-title">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-2 lg:items-center lg:px-8">
            <div>
                <p class="text-sm font-bold tracking-widest text-blue-700">PARRAINAGE</p>
                <h2 id="parrainage-accueil-title" class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Être présent, chaque mois.</h2>
                <p class="mt-5 text-lg leading-8 text-gray-600">Contribuer à la scolarité et aux repas d’un enfant, ou soutenir l’accès aux soins. Découvrez nos programmes et préparez votre engagement avec notre équipe.</p>
                <a href="{{ route('parrainage.index') }}" class="mt-7 inline-flex rounded-full bg-blue-600 px-7 py-4 font-bold text-white transition-colors hover:bg-blue-700">Découvrir le parrainage <span class="ml-3" aria-hidden="true">→</span></a>
            </div>
            <ul class="space-y-4">
                @foreach($programmesParrainage as $programme)
                    <li>
                        <a href="{{ route('parrainage.index') }}#programme-{{ $programme->code }}" class="flex items-center gap-5 rounded-2xl border border-blue-100 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                            <span class="shrink-0 text-blue-700"><x-parrainage-icon :programme="$programme->code" /></span>
                            <span>
                                <span class="block text-lg font-bold text-gray-900">{{ $programme->titre }}</span>
                                <span class="mt-1 block text-sm text-gray-600">
                                    @if($programme->montant_mensuel_centimes !== null)
                                        {{ number_format($programme->montant_mensuel_centimes / 100, 2, ',', ' ') }} € / mois · ≈ {{ \App\Services\Money::fcfa($programme->montant_mensuel_centimes / 100) }}
                                    @else
                                        Un montant mensuel libre
                                    @endif
                                </span>
                            </span>
                            <span class="ml-auto text-blue-700" aria-hidden="true">→</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif
