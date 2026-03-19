@extends('admin.layouts.admin')
@section('admin')
    <div class="p-8 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.payment-sections.index') }}"
                        class="p-2.5 bg-slate-800 border border-slate-700 text-slate-400 hover:text-white rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-white">Просмотр секции</h1>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.payment-sections.edit', $section) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/20">
                        Редактировать
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="p-8">
                        <div class="flex items-start justify-between mb-8">
                            <div class="flex items-center gap-5">
                                <div
                                    class="w-16 h-16 bg-slate-900 border border-slate-700 rounded-2xl flex items-center justify-center text-indigo-400 shadow-inner">
                                    <i class="{{ $section->icon ?? 'bi-layers' }} text-3xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ $section->title }}</h2>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span
                                            class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $section->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-700 text-slate-400' }}">
                                            {{ $section->is_active ? 'Активна' : 'Черновик' }}
                                        </span>
                                        <span class="text-slate-500 text-xs font-mono">Порядок:
                                            #{{ $section->sort_order }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Краткое
                                    описание</h4>
                                <p class="text-slate-300 leading-relaxed text-lg italic">
                                    "{{ $section->short_desc ?? 'Описание отсутствует' }}"
                                </p>
                            </div>

                            <hr class="border-slate-700/50">

                            <div>
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Подробная
                                    информация</h4>
                                <div class="prose prose-invert max-w-none text-slate-400 leading-relaxed">
                                    {!! nl2br(e($section->long_desc)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="px-8 py-4 bg-slate-900/50 border-t border-slate-700 flex justify-between items-center text-[10px] text-slate-500 uppercase tracking-widest">
                        <span>ID: {{ $section->id }}</span>
                        <span>Создано:
                            {{ $section->created_at ? $section->created_at->format('d.m.Y H:i') : 'Дата не указана' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
