@props(['item', 'optimized' => false])

@php
    $url = $item->getFullUrl();
    $isActive = $item->isCurrentlyActive();
    $icon = $item->icon; // The Material Symbol name (e.g., 'map')
@endphp

<a
    href="{{ $url }}"
    wire:navigate
    class="relative group flex items-center gap-2 text-sm uppercase tracking-widest transition-colors hover:text-prestige-gold {{ $isActive ? 'text-prestige-gold' : '' }}"
>
    @if($icon)
        <span class="material-symbols-outlined text-lg normal-case">{{ $icon }}</span>
    @endif
    {{ $item->getDisplayTitle() }}

    {{-- underline --}}
    <span
        class="absolute -bottom-2 left-0 w-full h-0.5 bg-prestige-gold origin-left transition-transform duration-300 scale-x-0 group-hover:scale-x-100 {{ $isActive ? 'scale-x-100' : '' }}"
    ></span>
</a>
