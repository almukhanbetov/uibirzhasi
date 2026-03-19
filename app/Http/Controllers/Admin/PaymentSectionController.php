<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PaymentSection;
use Illuminate\Http\Request;
class PaymentSectionController extends Controller
{
    public function index()
    {
        $sections = PaymentSection::orderBy('sort_order', 'asc')->get();    
    
        return view('admin.payment-sections.index', compact('sections'));
    }
    public function create()
    {
        $section = new PaymentSection();
       
        return view('admin.payment-sections.create', compact('section'));
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
            $data['sort_order'] = PaymentSection::max('sort_order') + 1;
        }
        PaymentSection::create($data);
        return redirect()->route('admin.payment-sections.index')->with('success', 'Секция оплаты создана');
    }
    public function show(PaymentSection $payment_section)
    {
        return view('admin.payment-sections.show', ['section' => $payment_section]);
    }
    public function edit(PaymentSection $payment_section)
    {
        return view('admin.payment-sections.edit', ['section' => $payment_section]);
    }

    public function update(Request $request, PaymentSection $paymentSection)
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

        $paymentSection->update($data);

        return redirect()->route('admin.payment-sections.index')->with('success', 'Данные обновлены');
    }

    public function destroy(PaymentSection $paymentSection)
    {
        $paymentSection->delete();
        return back()->with('success', 'Секция удалена');
    }
}