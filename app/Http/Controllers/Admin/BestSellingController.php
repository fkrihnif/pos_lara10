<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BestSellingController extends Controller
{
    public function index(Request $request){
         //barang terlaris
         $fromDate = $request->get('from_date');
         $toDate = $request->get('to_date');

         $transactions = Transaction::count();

        //jika ada data penjualan tampilkan
        if ($transactions > 0) {
            if ($fromDate) {
                $productTransactions = Product::where('price', '>', 0)->with('productTransactions', function ($query) use ($fromDate, $toDate) {
                    $query->whereRaw(
                        "(created_at >= ? AND created_at <= ?)", 
                        [
                           $fromDate, 
                           $toDate
                        ]
                      );
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
                $productTransactions = Product::with('productTransactions')->get();
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
             }
        } else {
            $result = [];
            $totalData = 0;
        }
        


        return view('admin.best-selling.index', compact('result', 'totalData'));
    }
}
