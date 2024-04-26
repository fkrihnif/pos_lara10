<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0')->orderBy('id', 'DESC')->get();
        $products = Product::select('name', 'price', 'product_code', 'quantity')->get();
        return view('admin.transaction.index', compact('productTransactions', 'products'));
    }
    public function indexs()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0')->with('product')->orderBy('id', 'DESC')->get() ?? [];
        return response()->json([
            'message' => 'success',
            'data' => $productTransactions
        ]);
    }
    public function update(Request $request)
    {
        $productTransaction = ProductTransaction::find($request->id);

        $productTransaction->quantity = $request->quantity;
        $productTransaction->disc_rp = $request->disc_rp;
        $productTransaction->disc_prc = $request->disc_prc;
        $productTransaction->update();

        return response()->json([
            'message' => 'success',
            'data' => $productTransaction
        ], 200);
    }

    public function show(Request $request)
    {
        $productTransaction = ProductTransaction::find($request->id);
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $productTransaction
        ]); 
    }

    public function showLastProduct(Request $request)
    {
        $productTransaction = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $productTransaction
        ]); 
    }

    
    public function getProductCode(Request $request)
    {
        // $product = Product::where('product_code', $request->search)->first() ?? '';
        $product = Product::where('product_code', $request->search)->first(['id', 'name', 'price']) ?? '';
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);
    }
    public function addToCart(Request $request)
    {
        $product = Product::where('product_code', $request->product_code)->first();
        //cek apakah ada barcode ini di tabel produk?
        if($product) {
            //cek apakah yg ada isi di cart pada user ini
            $checkCart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first();
            if($checkCart){
                //cek apakah barcode ini sama dgn produk terakhir di cart
                $idLastProduct = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first()->product_id;
                $lastProduct = Product::where('id', $idLastProduct)->first()->product_code;

                if ($lastProduct == $request->product_code) {
                    $idLastCart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first()->id;
                    $productTransaction = ProductTransaction::find($idLastCart);
                    $productTransaction->quantity = $productTransaction->quantity + 1;
                    $productTransaction->save();
                    $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

                    return response()->json([
                        'message' => 'success',
                        'data' => $productTransaction
                    ]);
                }else {
                    DB::beginTransaction();
                    try {
                        $productTransaction = new ProductTransaction();
                        $productTransaction->user_id = auth()->user()->id;
                        $productTransaction->product_id = $product->id;
                        $productTransaction->quantity = 1;
                        $productTransaction->disc_rp = $request->disc_rp;
                        $productTransaction->disc_prc = $request->disc_prc;
                        $productTransaction->status = '0';
                        $productTransaction->save();
                        $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

                        DB::commit();
                        return response()->json([
                            'message' => 'success',
                            'data' => $productTransaction
                        ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => 'failed',
                        ], 500);
                    }
                }
            } else {
                DB::beginTransaction();
                try {
                    $productTransaction = new ProductTransaction();
                    $productTransaction->user_id = auth()->user()->id;
                    $productTransaction->product_id = $product->id;
                    $productTransaction->quantity = 1;
                    $productTransaction->disc_rp = $request->disc_rp;
                    $productTransaction->disc_prc = $request->disc_prc;
                    $productTransaction->status = '0';
                    $productTransaction->save();
                    $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

                    DB::commit();
                    return response()->json([
                        'message' => 'success',
                        'data' => $productTransaction
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'failed',
                    ], 500);
                }
            }
        } else {
            //klaau gk ada barcode
            return response()->json([
                'message' => 'failed',
            ], 500);
        }
    }

    public function deleteLastProduct(Request $request)
    {
        $cart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first();
        $cart->delete();

        return response()->json([
            'message' => 'berhasil dihapus yg terahir',
            'data' => $cart
        ], 200);
    }

    public function deleteCart(Request $request)
    {
        $cart = ProductTransaction::find($request->id);
        $cart->delete();

        return response()->json([
            'message' => 'success',
            'data' => $cart
        ], 200);
    }

    public function deleteAllCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $cart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id);
            $cart->delete();

            DB::commit();
            return response()->json([
                'message' => 'success',
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
            ], 500);
        }
    }

    public function totalBuy()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0')->get() ?? [];
        $total = [];

        foreach ($productTransactions as $product) {
   
            $price = $product->product->price;

            $total[] = $price * $product->quantity - ($product->disc_rp + ($product->disc_prc / 100) * ($price * $product->quantity));
        }
        $totalBuy = array_sum($total);
        return response()->json([
            'message' => 'success',
            'data' => $totalBuy
        ]);
    }

    public function generateUniqueCode()
    {
        $date = date('Ymd');

        //cek dulu apakah di tabel transaksi sudah ada data?
        $transaction = Transaction::count();
        if ($transaction > 0) {
            $last_transaction = Transaction::latest()->first()->created_at;
            $ubah = date('Y-m-d', strtotime($last_transaction));
            $today = date('Y-m-d');
            //cek apakah sudah ada transaksi hari ini?
            if ($ubah == $today) {
                $last_code = Transaction::orderBy('id', 'desc')->first()->transaction_code;
                $removed4char = substr($last_code, -5);
                $generate_code = 'MM' . $date . '-' .  str_pad($removed4char + 1, 5, "0", STR_PAD_LEFT);
            } else {
                $generate_code = 'MM' . $date . '-' . str_pad(1, 5, "0", STR_PAD_LEFT);
            }
        } else {
            $generate_code = 'MM' . $date . '-' . str_pad(1, 5, "0", STR_PAD_LEFT);
        }
    
        return $generate_code;
    }

    public function pay(Request $request)
    {
        DB::beginTransaction();
        try {
            $productTransaction = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0');
            if (count($productTransaction->get())) {
                $purchaseOrder = [];
                foreach ($productTransaction->get() as $product) {
                    //sesuaikan harga 1 3 6
    
                    $price = $product->product->price;
                    // $purchaseOrder[] = $price * $product->quantity;
                    $purchaseOrder[] = $price * $product->quantity - ($product->disc_rp + ($product->disc_prc / 100) * ($price * $product->quantity));
                }
                $totalPurchase = array_sum($purchaseOrder);
                $totalDiscPercent = ($request->get_total_disc_prc / 100) * $totalPurchase;
                $totalPurchaseFinal = $totalPurchase - $request->get_total_disc_rp - $totalDiscPercent ;

                $transaction = new Transaction;
                $transaction->user_id = auth()->user()->id;
                $transaction->transaction_code = $this->generateUniqueCode();
                $transaction->pay = $request->payment;
                $transaction->return = $request->return;
                $transaction->total_sementara = $totalPurchase;
                $transaction->purchase_order = $totalPurchaseFinal;
                $transaction->disc_total_rp = $request->get_total_disc_rp;
                $transaction->disc_total_prc = $request->get_total_disc_prc;
                $transaction->method = $request->method;
                $transaction->save();

                //kurangi quantity ke product saat checkout
                $cart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->pluck('id');
                for($i = 0; $i < count($cart); $i++){
                    $getQuantity = ProductTransaction::where('id', $cart[$i])->first()->quantity;
                    $getProductId = ProductTransaction::where('id', $cart[$i])->first()->product_id;
                    $produk = Product::find($getProductId);
                    $quantity = $produk->quantity - $getQuantity;
                    $produk->update(['quantity' => $quantity]);
                }

                $productTransaction->update([
                    'transaction_id' => $transaction->id,
                    'status' => '1',
                ]);
                DB::commit();
            }

            $transactionId = $transaction->id;
            $transactionn = Transaction::find($transactionId);
            $productTransactions = ProductTransaction::where('transaction_id', $transactionId)->get();
            return view('admin.report.print', compact('transactionn','productTransactions'));
        } catch (\Exception $e) {
            DB::rollback();
            $var = response()->json([
                'message' => 'Gagal',
                'data' => $e
            ], 500);
        }
        return $var;
    }

    public function payDirectly()
    {
        DB::beginTransaction();
        try {
            $productTransaction = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0');
            if (count($productTransaction->get())) {
                $purchaseOrder = [];
                foreach ($productTransaction->get() as $product) {
                    //sesuaikan harga 1 3 6
    
                    $price = $product->product->price;
                    // $purchaseOrder[] = $price * $product->quantity;
                    $purchaseOrder[] = $price * $product->quantity - ($product->disc_rp + ($product->disc_prc / 100) * ($price * $product->quantity));
                }
                $totalPurchase = array_sum($purchaseOrder);
                $totalPurchaseFinal = $totalPurchase;

                $transaction = new Transaction;
                $transaction->user_id = auth()->user()->id;
                $transaction->transaction_code = $this->generateUniqueCode();
                $transaction->pay = $totalPurchaseFinal;
                $transaction->return = 0;
                $transaction->total_sementara = $totalPurchase;
                $transaction->purchase_order = $totalPurchaseFinal;
                $transaction->disc_total_rp = null;
                $transaction->disc_total_prc = null;
                $transaction->method = "offline";
                $transaction->save();

                //kurangi quantity ke product saat checkout
                $cart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->pluck('id');
                for($i = 0; $i < count($cart); $i++){
                    $getQuantity = ProductTransaction::where('id', $cart[$i])->first()->quantity;
                    $getProductId = ProductTransaction::where('id', $cart[$i])->first()->product_id;
                    $produk = Product::find($getProductId);
                    $quantity = $produk->quantity - $getQuantity;
                    $produk->update(['quantity' => $quantity]);
                }

                $productTransaction->update([
                    'transaction_id' => $transaction->id,
                    'status' => '1',
                ]);
                DB::commit();
            }

            $transactionId = $transaction->id;
            $transactionn = Transaction::find($transactionId);
            $productTransactions = ProductTransaction::where('transaction_id', $transactionId)->get();
            return view('admin.report.print', compact('transactionn','productTransactions'));
        } catch (\Exception $e) {
            DB::rollback();
            $var = response()->json([
                'message' => 'Gagal',
                'data' => $e
            ], 500);
        }
        return $var;
    }
}
