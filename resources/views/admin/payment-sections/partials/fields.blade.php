<div class="md:col-span-2">
    <label class="block text-sm font-medium text-slate-400 mb-2">Заголовок</label>
    <input type="text" name="title" value="{{ old('title', $section->title ?? '') }}" required
        class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">
</div>

<div class="grid grid-cols-2 gap-6 md:col-span-2">
    <div>
        <label class="block text-sm font-medium text-slate-400 mb-2">Иконка (class)</label>
        <input type="text" name="icon" value="{{ old('icon', $section->icon ?? 'bi-credit-card') }}"
            class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-400 mb-2">Порядок</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order ?? 0) }}"
            class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">
    </div>
</div>

<div class="md:col-span-2">
    <label class="block text-sm font-medium text-slate-400 mb-2">Краткое описание</label>
    <textarea name="short_desc" rows="2" class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">{{ old('short_desc', $section->short_desc ?? '') }}</textarea>
</div>

<div class="md:col-span-2">
    <label class="block text-sm font-medium text-slate-400 mb-2">Полный текст</label>
    <textarea name="long_desc" rows="5" class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">{{ old('long_desc', $section->long_desc ?? '') }}</textarea>
</div>