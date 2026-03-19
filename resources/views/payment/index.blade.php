@extends('admin.layouts.admin')
@section('content')
<div class="p-8 bg-slate-900 min-h-screen">
    {{-- <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Секции оплаты</h1>
            <p class="text-slate-400 text-sm mt-1">Управление блоками на странице оплаты</p>
        </div>
        <a href="{{ route('payment_sections.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all">
            + Добавить секцию
        </a>
    </div> --}}
    <div class="grid grid-cols-1 gap-4">
        @foreach($sections as $section)
        <div class="bg-slate-800 border border-slate-700 p-5 rounded-2xl flex items-center justify-between group hover:border-indigo-500/50 transition-all">
            <div class="flex items-center gap-6">
                <div class="text-slate-600 font-mono text-lg w-8">
                    #{{ $section->sort_order }}
                </div>                
                <div class="w-12 h-12 bg-slate-900 border border-slate-700 rounded-xl flex items-center justify-center text-indigo-400 shadow-inner">
                    <i class="{{ $section->icon ?? 'bi-credit-card' }} text-xl"></i>
                </div>
                <div>
                    <h3 class="text-white font-bold flex items-center gap-3">
                        {{ $section->title }}
                        @if(!$section->is_active)
                            <span class="text-[10px] bg-red-500/10 text-red-400 px-2 py-0.5 rounded-full border border-red-500/20">Выключено</span>
                        @endif
                    </h3>
                    <p class="text-slate-500 text-xs mt-1">{{ Str::limit($section->short_desc, 100) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('payment_sections.edit', $section) }}" class="p-2.5 bg-slate-900 border border-slate-700 text-slate-400 hover:text-indigo-400 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </a>                
                <form action="{{ route('payment_sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Удалить эту секцию?')">
                    @csrf @method('DELETE')
                    <button class="p-2.5 bg-slate-900 border border-slate-700 text-slate-400 hover:text-red-400 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection