@extends('admin.layouts.admin')
@section('admin')
    <div class="p-8 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('admin.different-sections.update', $section) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="px-8 py-6 border-b border-slate-700 bg-slate-800/50 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">Редактирование: {{ $section->title }}</h2>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-500">Активна:</span>
                            <input type="checkbox" name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }}
                                class="rounded border-slate-700 bg-slate-900 text-indigo-600">
                        </div>
                    </div>

                    <div class="p-8 grid grid-cols-1 gap-6">
                        @include('admin.different-sections.partials.fields')
                    </div>

                    <div class="px-8 py-6 bg-slate-900/30 border-t border-slate-700 flex justify-end gap-4">
                        <a href="{{ route('admin.different-sections.index') }}"
                            class="px-6 py-2.5 text-slate-400 hover:text-white transition-colors">Отмена</a>
                        <button type="submit"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white px-10 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all">
                            Обновить данные
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
