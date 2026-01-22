@props(['item', 'optimized' => false])

@php
    $url = $item->getFullUrl();
    $isActive = $item->isCurrentlyActive();
    $icon = $item->icon; // The Material Symbol name (e.g., 'map')
@endphp

<li class="w-full flex justify-center">
    <a
        href="{{ $url }}"
        wire:navigate
        @click="mobileOpen = false"
        class="flex flex-col items-center gap-2 text-xs uppercase tracking-[0.3em] transition-colors hover:text-prestige-gold {{ $isActive ? 'text-prestige-gold' : '' }}"
    >
        @if($icon)
            <span class="material-symbols-outlined text-2xl">{{ $icon }}</span>
        @endif
        {{ $item->getDisplayTitle() }}
    </a>
</li>
