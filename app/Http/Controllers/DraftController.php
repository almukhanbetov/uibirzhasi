<?php

namespace App\Http\Controllers;

use App\Models\ListingDraft;
use App\Models\ListingDraftPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DraftController extends Controller
{
    /**
     * 📝 Автосохранение текста формы (AJAX)
     */
    public function save(Request $request)
    {
        $user = Auth::user();

        // Список полей, которые допустимо сохранять
        $data = $request->only([
            'type_id',
            'deal_type',
            'region_id',
            'city_id',
            'district_id',
            'area',
            'rooms',
            'price_base',
            'description',
        ]);

        $data['user_id'] = $user->id;

        // Если у нас уже есть draft_id — обновляем этот черновик
        if ($request->filled('draft_id')) {
            $draft = ListingDraft::where('id', $request->draft_id)
                ->where('user_id', $user->id)
                ->first();

            if ($draft) {
                $draft->update($data);
            } else {
                // Если неверный draft_id — просто создаём новый черновик
                $draft = ListingDraft::create($data);
            }
        } else {
            // Если draft_id ещё нет — создаём новый черновик
            $draft = ListingDraft::create($data);
        }

        return response()->json([
            'status'   => 'ok',
            'draft_id' => $draft->id,
        ]);
    }


    /**
     * 📸 Загрузка фото в черновик (Drag & Drop)
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'draft_id' => 'required|exists:listing_drafts,id',
            'file'     => 'required|image|max:8192', // до 8 MB
        ]);

        $draft = ListingDraft::where('id', $request->draft_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Сохраняем файл в storage/app/public/drafts/{draft_id}/
        $path = $request->file('file')->store("drafts/{$draft->id}", 'public');

        $photo = $draft->photos()->create([
            'url' => "/storage/{$path}",
        ]);

        return response()->json([
            'status'   => 'ok',
            'photo_id' => $photo->id,
            'url'      => $photo->url,
            'draft_id' => $draft->id,
        ]);
    }


    /**
     * ❌ Удаление фото из черновика
     */
    public function deletePhoto(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|exists:listing_draft_photos,id',
        ]);

        $photo = ListingDraftPhoto::where('id', $request->photo_id)
            ->whereHas('draft', fn($q) => $q->where('user_id', Auth::id()))
            ->firstOrFail();

        // Удаляем файл с диска
        $path = str_replace('/storage/', '', $photo->url);
        Storage::disk('public')->delete($path);

        // Удаляем запись в БД
        $photo->delete();

        return response()->json([
            'status' => 'deleted',
            'photo_id' => $request->photo_id,
        ]);
    }
}
