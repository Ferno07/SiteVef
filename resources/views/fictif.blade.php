<div class="cards-scroll-wrapper">
    <div class="cards-scroll">
        <div class="cards cards-animated">

            {{-- PREMIÈRE SÉRIE (vraie) --}}
            @foreach($projets as $index => $projet)
                <article class="card">
                    <img src="{{ asset($projet->image_path) }}" alt="{{ $projet->titre }}">
                    <div class="card-content">
                        <h3>{{ $projet->titre }}</h3>
                        <p>{{ $projet->description_courte }}</p>

                        <div class="card-details" style="display: none;">
                            <p>{{ $projet->description_longue }}</p>
                        </div>

                        <button class="btn small learn-more-btn" data-card="{{ $index }}">En savoir plus</button>
                    </div>
                </article>
            @endforeach

            {{-- DEUXIÈME SÉRIE (dupliquée pour l'infinite scroll) --}}
            @foreach($projets as $index => $projet)
                <article class="card">
                    <img src="{{ asset($projet->image_path) }}" alt="{{ $projet->titre }}">
                    <div class="card-content">
                        <h3>{{ $projet->titre }}</h3>
                        <p>{{ $projet->description_courte }}</p>

                        <div class="card-details" style="display: none;">
                            <p>{{ $projet->description_longue }}</p>
                        </div>

                        <button class="btn small learn-more-btn" data-card="{{ $index }}">En savoir plus</button>
                    </div>
                </article>
            @endforeach

        </div>
    </div>
</div>
