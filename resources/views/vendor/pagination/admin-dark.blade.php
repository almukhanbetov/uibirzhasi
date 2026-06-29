@if ($paginator->hasPages())
<div class="flex items-center justify-between mt-6">

    {{-- Счётчик --}}
    <p class="text-slate-400 text-sm">
        Показано {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} из {{ $paginator->total() }}
    </p>

    {{-- Кнопки --}}
    <div class="flex items-center gap-1">

        {{-- Назад --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 rounded-lg text-slate-600 text-sm cursor-not-allowed select-none">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm transition-colors">‹</a>
        @endif

        {{-- Страницы --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 py-1.5 text-slate-500 text-sm">…</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-sm font-bold min-w-[36px] text-center">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm transition-colors min-w-[36px] text-center">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Вперёд --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm transition-colors">›</a>
        @else
            <span class="px-3 py-1.5 rounded-lg text-slate-600 text-sm cursor-not-allowed select-none">›</span>
        @endif

    </div>
</div>
@endif
