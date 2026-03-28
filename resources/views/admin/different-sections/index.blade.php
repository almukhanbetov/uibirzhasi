@extends('admin.layouts.admin')
@section('admin')
    <div class="p-8 bg-slate-900 min-h-screen">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Секции оплаты</h1>
                <p class="text-slate-400 text-sm mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Управление контентом и порядком отображения
                </p>
            </div>

            <a href="{{ route('admin.different-sections.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Добавить секцию
            </a>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="px-6 py-5">Порядок</th>
                            <th class="px-6 py-5">Секция</th>
                            <th class="px-6 py-5">Статус</th>
                            <th class="px-6 py-5 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($sections as $section)
                            <tr class="hover:bg-slate-700/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-900 text-indigo-400 font-mono text-xs border border-slate-700">
                                        {{ $section->sort_order }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-center text-slate-400 group-hover:text-indigo-400 transition-colors">
                                            <i class="{{ $section->icon ?? 'bi bi-layers' }} text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-200">{{ $section->title }}</div>
                                            <div class="text-xs text-slate-500">{{ Str::limit($section->short_desc, 45) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($section->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Активен
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-700 text-slate-400 border border-slate-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Черновик
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.different-sections.show', $section) }}"
                                            class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all"
                                            title="Просмотр">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.different-sections.edit', $section) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-500/10 rounded-lg transition-all"
                                            title="Редактировать">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.different-sections.destroy', $section) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Вы уверены? Это действие нельзя отменить.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all"
                                                title="Удалить">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-slate-700 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <span class="text-slate-500">Секций пока нет. Создайте первую!</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
