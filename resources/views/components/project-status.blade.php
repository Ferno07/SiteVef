@props(['status'])
@php
    $label = ['a_venir' => 'À venir', 'en_cours' => 'En cours', 'realise' => 'Réalisé'][$status] ?? 'Statut non renseigné';
    $tone = in_array($status, ['a_venir', 'en_cours', 'realise']) ? $status : 'neutre';
@endphp
<span {{ $attributes->class(['project-status', 'project-status--'.$tone]) }}>
    <span class="project-status__marker" aria-hidden="true">{{ $status === 'realise' ? '✓' : '' }}</span>
    {{ $label }}
</span>
