<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Http\Request;

class PageBlockController extends Controller
{
    public function index(Page $page)
    {
        $blocks = $page->blocks()->orderBy('sort_order')->get();

        return view('admin.blocks.index', compact('page','blocks'));
    }

    public function create(Page $page)
    {
        return view('admin.blocks.create', compact('page'));
    }

    public function store(Request $request, Page $page)
    {
        $page->blocks()->create([
            'type' => $request->type,
            'data' => json_decode($request->data, true),
            'sort_order' => $request->sort_order,
            'is_active' => true
        ]);

        return redirect()->route('pages.blocks.index',$page);
    }

    public function edit(PageBlock $block)
    {
        return view('admin.blocks.edit', compact('block'));
    }

    public function update(Request $request, PageBlock $block)
    {
        $block->update([
            'type' => $request->type,
            'data' => json_decode($request->data, true),
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active')
        ]);

        return back();
    }

    public function destroy(PageBlock $block)
    {
        $block->delete();
        return back();
    }
}
