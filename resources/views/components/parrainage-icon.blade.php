@props(['programme'])
<svg {{ $attributes->merge(['class' => 'h-7 w-7']) }} viewBox="0 0 24 24" fill="none"
     stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @if($programme === \App\Models\ProgrammeParrainage::ENFANT)
        <path d="M12 6.5c-2.7-2-6.4-2-10-1v14c3.6-1 7.3-1 10 1 2.7-2 6.4-2 10-1v-14c-3.6-1-7.3-1-10 1Z" />
        <path d="M12 6.5v14M6 9h2M6 13h2M16 9h2M16 13h2" />
    @else
        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z" />
        <path d="M8 12h8M12 8v8" />
    @endif
</svg>
