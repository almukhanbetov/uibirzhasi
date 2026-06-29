<?php
namespace App\Http\Controllers;
use App\Http\Requests\ListingStoreRequest;
use App\Http\Requests\ProfileListingRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\City;
use App\Models\District;
use App\Models\Listing;
use App\Models\Photo;
use App\Models\Region;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $listings = Listing::query()
            ->where('user_id', $user->id)
            ->with(['city', 'district', 'type'])
            ->latest()
            ->paginate(12);
        return view('profile.index', [
            'user' => $user,
            'listings' => $listings,
        ]);
    }
    public function create()
    {
        return view('profile.create', [
            'regions' => Region::all(),
            'cities' => City::all(),
            'districts' => District::all(),
            'types' => Type::all(),
        ]);
    }
    public function store(ProfileListingRequest $request)
    {
        // dd($request->input('deal_type'));
        $data = $request->validated();
        // ✅ Создаём объявление
        $user_id = Auth::user()->id;

        $listing = Listing::create([
            'user_id'       => $user_id,
            'deal_type'     => $data['deal_type'],
            'type_id'       => $data['type_id'],
            'region_id'     => $data['region_id'],
            'city_id'       => $data['city_id'],
            'district_id'   => $data['district_id'],
            'area'          => $data['area'],
            'rooms'         => $data['rooms'],
            'price_base'    => $data['price_base'],
            'price_current' => $data['price_base'],
            'description'   => $data['description'],
            'moderation'    => 'pending', // Можно менять на approved после модерации
        ]);

        // ✅ Если есть фото — сохраняем
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('uploads/listings', 'public');
                $listing->photos()->create([
                    'url' => '/storage/' . $path
                ]);
            }
        }
        // ✅ Возврат с сообщением об успехе
        return redirect()
            ->route('profile.index')
            ->with('success', 'Объявление успешно добавлено!');
    }
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $listing = Listing::with(['region', 'city', 'district', 'type', 'photos'])
            ->where('id', $id)
            ->where('user_id', $user_id) // показываем только свои объявления
            ->firstOrFail();
        $statusHistory = $listing->statusHistory()
        ->latest()
        ->get();

    return view('profile.show', compact('listing', 'statusHistory'));    


        return view('profile.show', compact('listing'));
    }
    public function edit($id)
    {
        $user_id = Auth::user()->id;

        $listing = Listing::with(['region', 'city', 'district', 'type', 'photos'])
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        // Передаем данные в форму
        $regions = Region::all();
        $cities = City::all();
        $districts = District::all();
        $types = Type::all();
        return view('profile.edit', compact('listing', 'regions', 'cities', 'districts', 'types'));
    }
    public function update(ProfileUpdateRequest $request, $id)
    {

        $user_id = Auth::user()->id;
        $listing = Listing::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();
        $validated = $request->validated();

        $listing->update([
            'deal_type'    => $validated['deal_type'], // 🔥 ОБЯЗАТЕЛЬНО
            'region_id' => $validated['region_id'],
            'city_id' => $validated['city_id'],
            'district_id' => $validated['district_id'],
            'type_id' => $validated['type_id'],
            'area' => $validated['area'],
            'rooms' => $validated['rooms'],
            'price_base' => $validated['price_base'],
            'price_current' => $validated['price_base'],
            'description' => $validated['description'],
            'moderation' => 'pending',
        ]);
        // Обработка фото
        if ($request->hasFile('photos')) {
            foreach ($listing->photos as $oldPhoto) {
                $filePath = str_replace('storage/', 'public/', $oldPhoto->url);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                $oldPhoto->delete();
            }
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('uploads/listings', 'public');
                $listing->photos()->create(['url' => 'storage/' . $path]);
            }
        }
        return redirect()->route('profile.index')->with('success', 'Объявление обновлено');
    }

    public function destroy($id)
    {
        $userId = Auth::user()->id;


        // Находим объявление, принадлежащее текущему пользователю
        $listing = Listing::where('id', $id)
            ->where('user_id', $userId)
            ->with('photos')
            ->firstOrFail();

        // Удаляем все фотографии из хранилища
        foreach ($listing->photos as $photo) {
            $filePath = str_replace('storage/', 'public/', $photo->url);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            $photo->delete();
        }

        // Удаляем само объявление
        $listing->delete();

        // Возвращаем пользователя обратно со всплывающим сообщением
        return redirect()
            ->route('profile.index')
            ->with('success', 'Объявление успешно удалено.');
    }


    public function deletePhoto($photoId)
    {

        $photo = Photo::findOrFail($photoId);



        $listing = Listing::findOrFail($photoId);

        $photo = Photo::findOrFail($photoId);


        // Проверяем, что это фото действительно принадлежит пользователю
        if ($photo->listing->user_id !== Auth::user()->id) {
            abort(403, 'Нет доступа для удаления этого фото');
        }

        // Удаляем файл из хранилища
        $filePath = str_replace('storage/', 'public/', $photo->url);
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Удаляем запись из БД
        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function passwordForm(): View
    {
        return view('profile.password');
    }

    public function passwordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'      => ['required', 'current_password'],
            'password'              => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'current_password.required'  => 'Введите текущий пароль.',
            'current_password.current_password' => 'Текущий пароль неверный.',
            'password.required'          => 'Введите новый пароль.',
            'password.min'               => 'Пароль должен быть не менее 6 символов.',
            'password.confirmed'         => 'Пароли не совпадают.',
            'password_confirmation.required' => 'Повторите новый пароль.',
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Пароль успешно изменён.');
    }
}
