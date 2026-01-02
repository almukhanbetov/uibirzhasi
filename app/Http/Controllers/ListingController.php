<?php
namespace App\Http\Controllers;

use App\Http\Requests\ListingFilterRequest;
use App\Http\Requests\ListingStoreRequest;
use App\Models\Listing;
use App\Models\Type;
use App\Models\Region;
use App\Models\City;
use App\Models\District;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    // 🟦 Форма добавления
    public function create()
    {
        return view('profile.create', [
            'types'    => Type::all(),
            'regions'  => Region::all(),
            'cities'   => City::all(),
            'districts'=> District::all()
        ]);}
    // 🟩 Список объявлений пользователя
    public function index()
    {
        $listings = Listing::where('user_id', Auth::id())
            ->with(['photos'])
            ->latest()
            ->get();

        return view('profile.index', compact('listings'));
    }
    // 🟢 Сохранение объявления
    public function store(ListingStoreRequest $request)
    {
        $data = $request->validated();
        dd($data);
        $data['user_id'] = Auth::id();
        $data['moderation'] = 'pending'; // Можно потом поменять при модерации

        $listing = Listing::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('uploads/listings', 'public');
                $listing->photos()->create([
                    'url' => '/storage/' . $path
                ]);
            }
        }
        return redirect()
            ->route('profile.index')
            ->with('success', 'Объявление успешно добавлено!');
    }
    // 🟨 Страница просмотра
    public function show($id)
    {
        $listing = Listing::with(['photos', 'type', 'city', 'district', 'region', 'user'])
            ->findOrFail($id);

        return view('listings.show', compact('listing'));
    }

    // 🟥 Удаление объявления
    public function destroy(Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) abort(403);

        $listing->delete();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Объявление удалено.');
    }

    // 🔎 AJAX фильтр поиска
    public function ajaxSearch(ListingFilterRequest $request)
    {
        $query = Listing::with(['photos', 'type', 'user', 'city', 'district']);
        

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        if ($request->filled('deal_type')) {
            $query->where('deal_type', $request->deal_type);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('rooms')) {
            $query->where('rooms', $request->rooms);
        }

        if ($request->filled('area_min')) {
            $query->where('area', '>=', $request->area_min);
        }

        if ($request->filled('area_max')) {
            $query->where('area', '<=', $request->area_max);
        }

        if ($request->filled('price_min')) {
            $query->where('price_current', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_current', '<=', $request->price_max);
        }

        $listings = $query->latest()->take(50)->get();

        return view('components.listings-grid', compact('listings'))->render();
    }
}
