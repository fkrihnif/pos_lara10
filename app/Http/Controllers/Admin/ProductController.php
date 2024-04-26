<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search_product = $request->get('search_product');
        $search_categoryItem = $request->get('category_item_search');
        $search_category = $request->get('category_search');

        if($search_product){
            $products = Product::where('product_code','like',"%".$search_product."%")->orWhere('name','like',"%".$search_product."%")->paginate(10);
        }else if($search_categoryItem){
            $id_categoryItem = CategoryItem::where('category_item', $search_categoryItem)->first()->id;
            $products = Product::where('category_item_id', $id_categoryItem)->paginate(20);
        }else if($search_category){
            $id_category = Category::where('name', $search_category)->first()->id;
            $products = Product::where('category_id', $id_category)->paginate(20);
        } else{
            $products = Product::orderBy('id', 'DESC')->paginate(10);
        }
        
        $categories = Category::all();
        $category_items = CategoryItem::all();
        return view('admin.product.index', compact('products', 'categories', 'category_items'));
    }

    public function generateUniqueCode()
    {
        $randomNumber = random_int(10000, 99999);
        $characters = 'ABCDEFGHJKLMNPRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        
        $char = '';
        while (strlen($char) < 1) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $char = $char.$character;
        }

        $code = $char.$randomNumber;

        if (Product::where('product_code', $code)->exists()) {
        $this->generateUniqueCode();
        }
        return $code;
    }

    public function store(Request $request)
    {
        if ($request->product_code == null) {
            $product = new Product();
            $product->product_code = $this->generateUniqueCode();
        } else {
            $validatedData = $request->validate([
                'product_code' => 'required|unique:product'
            ]);
            $product = new Product();
            $product->product_code = $request->product_code;            
        }
        $product->name = $request->name;
        if ($request->quantity == '') {
            $quantity = "0";
        } else {
            $quantity = $request->quantity;
        }
        $product->quantity = $quantity;
        $product->price = $request->price;
        $product->capital_price = $request->get('capital_price');
        $product->category_id = $request->category_id;
        $product->category_item_id = $request->category_item_id;

        $product->save();
        toast('Data produk berhasil ditambah')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $validatedData = $request->validate([
            'product_code' => 'required|unique:product,product_code,' . $request->id,
        ]);

        $product->product_code = $request->get('product_code');
        $product->name = $request->get('name');
        $product->quantity = $request->get('quantity');
        $product->price = $request->get('price');
        $product->capital_price = $request->get('capital_price');
        $product->category_id = $request->get('category_id');
        $product->category_item_id = $request->get('category_item_id');
        $product->save();

        toast('Data produk berhasil diubah')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $product->delete();
        toast('Data produk berhasil dihapus')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }
}

