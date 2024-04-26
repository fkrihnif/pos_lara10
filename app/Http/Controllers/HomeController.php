<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Supply;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = Transaction::count();
        $transactions = Transaction::count();
        $categories = Category::count();
        $products = Product::count();
        $supplies = Supply::count();
        $getProducts = Product::all();

        if (auth()->user()->role == 'admin') {
            $transactionGet = Transaction::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        } else {
            $transactionGet = Transaction::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        }
      
        //data pembelian hari ini
        $supplierToday = Supply::whereDate('supply_date', date('Y-m-d'))->orderBy('id', 'DESC')->get();

        //barang terjual (harian) 
        //cek dulu apakah ada penjualan hari ini?
        if (ProductTransaction::whereDate('created_at', Carbon::today())->exists()) {
            $selling = 1;

            $productTransactions = Product::where('category_id', '>=', 0)->with('productTransactions', function ($query) {
                $query->whereDate('created_at', Carbon::today());
                })->get();
            foreach($productTransactions as $c){
                if ($c->productTransactions->sum('quantity') > 0) {
                    $totalProduct [] = $c->productTransactions->sum('quantity');
                    $nameProduct [] = $c->name;
                    $codeProduct [] = $c->product_code;
                    $priceProduct [] = $c->price;
                    $categoryItem [] = $c->categoryItem->category_item;
                    $category [] = $c->category->name;
                }
            }
    
            $result = [
                'total' => $totalProduct,
                'product' => $nameProduct,
                'code' => $codeProduct,
                'price' => $priceProduct,
                'categoryItem' => $categoryItem,
                'category' => $category
            ];
    
            $totalData = count($result['code']);

        } else {
            $selling = 0;
            $result = [];
            $totalData = [];
        }
        if(auth()->user()->role == 'admin'){
            
            return view('admin.dashboard.index', compact('transactions','categories','products','supplies','transactionGet', 'supplierToday', 'result', 'totalData', 'selling'));
        } else {
            return view('kasir.dashboard.index', compact('transactions','categories','products','supplies','transactionGet','result', 'supplierToday'));
        }
    }
}