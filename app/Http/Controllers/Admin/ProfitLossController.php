<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Supply;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        if ($fromDate) {
            $transactions = Transaction::whereRaw(
                "(created_at >= ? AND created_at <= ?)", 
                [
                   $fromDate ." 00:00:00", 
                   $toDate ." 23:59:59"
                ]
              )->sum('purchase_order');
              $supplies = Supply::whereRaw(
                "(supply_date >= ? AND supply_date <= ?)", 
                [
                   $fromDate, 
                   $toDate
                ]
              )->sum('total');

        } else {
            $transactions = Transaction::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->sum('purchase_order');
            $supplies = Supply::whereDate('supply_date', date('Y-m-d'))->orderBy('id', 'DESC')->sum('total');
        }
        
        return view('admin.profit-loss.index', compact('transactions', 'supplies'));
    }
}
