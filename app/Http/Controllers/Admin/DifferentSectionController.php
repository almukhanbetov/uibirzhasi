<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DifferentSection;
use Illuminate\Http\Request;
class DifferentSectionController extends Controller
{
    public function index()
    {
        $sections = DifferentSection::orderBy('sort_order', 'asc')->get();    
    
        return view('admin.different-sections.index', compact('sections'));
    }
    public function create()
    {
        $section = new DifferentSection();
       
        return view('admin.different-sections.create', compact('section'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_desc' => 'nullable|string|max:1000',
            'long_desc' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        // Если порядок не указан, ставим в конец
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = DifferentSection::max('sort_order') + 1;
        }
        DifferentSection::create($data);
        return redirect()->route('admin.different-sections.index')->with('success', 'Секция оплаты создана');
    }
    public function show(DifferentSection $different_section)
    {
        return view('admin.different-sections.show', ['section' => $different_section]);
    }
    public function edit(DifferentSection $different_section)
    {
        return view('admin.different-sections.edit', ['section' => $different_section]);
    }

    public function update(Request $request, DifferentSection $differentSection)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_desc' => 'nullable|string|max:1000',
            'long_desc' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
        ]);

        // Обработка чекбокса (если его нет в запросе — значит false)
        $data['is_active'] = $request->has('is_active');

        $differentSection->update($data);

        return redirect()->route('admin.different-sections.index')->with('success', 'Данные обновлены');
    }

    public function destroy(DifferentSection $differentSection)
    {
        $differentSection->delete();
        return back()->with('success', 'Секция удалена');
    }
}