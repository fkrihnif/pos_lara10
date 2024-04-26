<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Supply;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = Transaction::count();
        $transactions = Transaction::count();
        $categories = Category::count();
        $products = Product::count();
        $supplies = Supply::count();
        $getProducts = Product::all();
        $transactionGet = Transaction::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
      
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

        return view('admin.dashboard.index', compact('transactions','categories','products','supplies','transactionGet', 'supplierToday', 'result', 'totalData', 'selling'));
    }
}
