<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryItem;
use Illuminate\Http\Request;

class CategoryItemController extends Controller
{
    public function index()
    {
        $categories = CategoryItem::orderBy('id', 'DESC')->get();
        return view('admin.category-item.index', compact('categories'));
    }
    public function store(Request $request)
    {
        CategoryItem::create($request->all());
        toast('Data kategori berhasil ditambah')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $category = CategoryItem::find($request->id);
        $category->update($request->all());
        toast('Data kategori berhasil diubah')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }
    public function delete(Request $request)
    {
        $category = CategoryItem::find($request->id);
        $category->delete();
        toast('Data kategori berhasil dihapus')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }
}
