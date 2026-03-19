@extends('admin.layouts.admin')
@section('admin')
    <div class="p-8 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <form
                action="{{ $section->exists ? route('payment_sections.update', $section) : route('payment_sections.store') }}"
                method="POST" class="space-y-6">
                @csrf
                @if ($section->exists)
                    @method('PUT')
                @endif

                <div class="bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="px-8 py-6 border-b border-slate-700 bg-slate-800/50 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">
                            {{ $section->exists ? 'Настройка секции' : 'Новая секция оплаты' }}</h2>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="sr-only peer"
                                {{ old('is_active', $section->is_active ?? true) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-slate-400">Активна</span>
                        </label>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-400 mb-2">Заголовок (Title)</label>
                                <input type="text" name="title" value="{{ old('title', $section->title) }}" required
                                    class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl border py-3 px-4 transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-2">Иконка (Bootstrap
                                    Class)</label>
                                <input type="text" name="icon" value="{{ old('icon', $section->icon) }}"
                                    placeholder="bi-credit-card"
                                    class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl border py-3 px-4 transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-2">Порядок сортировки</label>
                                <input type="number" name="sort_order"
                                    value="{{ old('sort_order', $section->sort_order ?? 0) }}"
                                    class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl border py-3 px-4 transition-all">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-400 mb-2">Краткое описание (Short
                                    Desc)</label>
                                <textarea name="short_desc" rows="2"
                                    class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl border py-3 px-4 transition-all">{{ old('short_desc', $section->short_desc) }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-400 mb-2">Подробная информация (Long
                                    Text)</label>
                                <textarea name="long_desc" rows="6"
                                    class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl border py-3 px-4 transition-all">{{ old('long_desc', $section->long_desc) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-slate-900/30 border-t border-slate-700 flex justify-end gap-4">
                        <a href="{{ route('payment_sections.index') }}"
                            class="px-6 py-2.5 text-slate-400 hover:text-white transition-colors">Отмена</a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all">
                            {{ $section->exists ? 'Сохранить изменения' : 'Создать секцию' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection