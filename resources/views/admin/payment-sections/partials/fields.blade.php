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
    <textarea name="short_desc" rows="2" id="short_desc"
        class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">{{ old('short_desc', $section->short_desc ?? '') }}</textarea>
</div>

<div class="md:col-span-2">
    <label class="block text-sm font-medium text-slate-400 mb-2">Полный текст</label>
    <textarea name="long_desc" rows="5" id="long_desc"
        class="w-full bg-slate-900 border-slate-700 text-slate-200 focus:border-indigo-500 rounded-xl border py-3 px-4 transition-all">{{ old('long_desc', $section->long_desc ?? '') }}</textarea>
</div>
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editorElement = document.querySelector('#long_desc');
            if (editorElement) {
                ClassicEditor
                    .create(editorElement, {
                        // Настройки тулбара (можно убрать лишнее)
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        // Настройка высоты
                        editor.editing.view.change(writer => {
                            writer.setStyle('min-height', '200px', editor.editing.view.document
                                .getRoot());
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Настройка темной темы для CKEditor */
        :root {
            --ck-color-base-background: #0f172a;
            /* Твой bg-slate-900 */
            --ck-color-toolbar-background: #1e293b;
            /* Твой bg-slate-800 */
            --ck-color-toolbar-border: #334155;
            --ck-color-base-border: #334155;
            --ck-color-text: #e2e8f0;
            --ck-color-button-default-hover-background: #334155;
        }

        .ck-editor__editable_inline {
            background-color: #0f172a !important;
            /* Внутри редактора тоже темно */
            color: #e2e8f0 !important;
        }
    </style>
@endpush
