<div class="dashboard-stats" style="margin-top:16px">
<div class="stat-card">
<h3>Projets publiés</h3>
<p class="stat-number">{{ $projets->where('publication','publie')->count() }}</p>
</div>
<div class="stat-card">
<h3>Projets réalisés</h3>
<p class="stat-number">{{ $projets->where('statut','realise')->count() }}</p>
</div>
<div class="stat-card">
<h3>Articles publiés</h3>
<p class="stat-number">{{ \App\Models\Article::published()->count() }}</p>
</div>
<div class="stat-card">
<h3>Dons confirmés</h3>
<p class="stat-number">{{ number_format(\App\Models\Donation::where('status','confirmed')->sum('amount_centimes')/100,2,',',' ') }} €</p>
</div>
</div>
<section class="editorial-section" style="margin-top:24px">
<h2>Dernières activités éditoriales</h2>
@php($activities=$projets->map(fn($p)=>['titre'=>$p->titre,'date'=>$p->updated_at,'type'=>'Projet'])->concat($articles->map(fn($a)=>['titre'=>$a->titre,'date'=>$a->updated_at,'type'=>'Actualité']))->sortByDesc('date')->take(8))@forelse($activities as $activity)<p>{{ $activity['date']->format('d/m/Y H:i') }} · {{ $activity['type'] }} · {{ $activity['titre'] }}</p>
@empty<p>Aucune activité enregistrée.</p>
@endforelse
</section>
