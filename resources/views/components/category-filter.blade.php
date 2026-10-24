@props(['allLabel' => 'All'])

@php
    $selectedCategory = request('category');
    $activeClasses = 'bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold text-xs px-5 py-2 rounded-full transition shadow';
    $inactiveClasses = 'bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition';
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-2']) }}>
    <a href="{{ request()->url() }}" class="{{ $selectedCategory ? $inactiveClasses : $activeClasses }}">{{ $allLabel }}</a>
    @foreach (\App\Enums\DisruptionCategory::cases() as $category)
        <a href="{{ request()->url() }}?category={{ $category->value }}" class="{{ $selectedCategory === $category->value ? $activeClasses : $inactiveClasses }}">{{ $category->label() }}</a>
    @endforeach
</div>
