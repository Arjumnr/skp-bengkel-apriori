<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RuleController extends Controller
{
    public function index(Request $request){
        try {
            
        return view('admin.rule.index');
        
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
   

    public function frekuensiItemset1(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('transactions_items')
                    ->join('product', 'transactions_items.product_id', '=', 'product.id')
                    ->select('product.name as product_name', DB::raw('SUM(transactions_items.qty) as purchase_count'))
                    ->groupBy('product.name')
                    ->orderBy('purchase_count', 'desc')
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function supportMinimum(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Ambil semua transaksi
                $totalTransactions = DB::table('transactions_items')->distinct('transaction_id')->count('transaction_id');
                
                $data = DB::table('transactions_items')
                    ->join('product', 'transactions_items.product_id', '=', 'product.id')
                    ->select('product.name as itemset', DB::raw('SUM(transactions_items.qty) as qty'))
                    ->groupBy('product.name')
                    ->orderBy('qty', 'desc')
                    ->get()
                    ->map(function ($item) use ($totalTransactions) {
                        $support = ($item->qty / $totalTransactions) * 100;
                        
                        // Tentukan apakah itemset harus di-prune atau di-join
                        $frequent = $support >= 20 ? 'Join' : 'Prune';
                        
                        return [
                            'itemset' => $item->itemset,
                            'qty' => $item->qty,
                            'support' => number_format($support, 2) . '%',
                            'frequent' => $frequent
                        ];
                    });

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function kombinasi2itemset(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Ambil semua transaksi
                $transactions = DB::table('transactions_items')
                    ->select('transaction_id', 'product_id')
                    ->get()
                    ->groupBy('transaction_id');

                $itemSets = [];
                $totalTransactions = $transactions->count();

                foreach ($transactions as $transaction) {
                    $productIds = $transaction->pluck('product_id')->toArray();
                    $count = count($productIds);

                    // Buat kombinasi 2-item
                    for ($i = 0; $i < $count; $i++) {
                        for ($j = $i + 1; $j < $count; $j++) {
                            $item1 = $productIds[$i];
                            $item2 = $productIds[$j];
                            $key = $item1 < $item2 ? "$item1-$item2" : "$item2-$item1";

                            if (!isset($itemSets[$key])) {
                                $itemSets[$key] = 0;
                            }
                            $itemSets[$key]++;
                        }
                    }
                }

                // Ambil nama produk
                $productNames = DB::table('product')->pluck('name', 'id')->toArray();

                // Convert array to collection for easy manipulation
                $itemSets = collect($itemSets)->map(function ($count, $key) use ($totalTransactions, $productNames) {
                    $products = explode('-', $key);
                    $productNamesArray = array_map(fn($id) => $productNames[$id] ?? 'Unknown', $products);
                    $support = ($count / $totalTransactions) * 100;

                    return [
                        'itemset' => implode(' and ', $productNamesArray),
                        'qty' => $count,
                        'support' => number_format($support, 2) . '%',
                        'frequent' => $support >= 20 ? 'Join' : 'Prune'
                    ];
                })->sortByDesc('qty');

                return DataTables::of($itemSets)
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function hitung(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Ambil semua transaksi
                $transactions = DB::table('transactions_items')
                    ->select('transaction_id', 'product_id')
                    ->get()
                    ->groupBy('transaction_id');
    
                $itemSets = [];
                $totalTransactions = $transactions->count();
    
                foreach ($transactions as $transaction) {
                    $productIds = $transaction->pluck('product_id')->toArray();
                    $count = count($productIds);
    
                    // Buat kombinasi 2-item
                    for ($i = 0; $i < $count; $i++) {
                        for ($j = $i + 1; $j < $count; $j++) {
                            $item1 = $productIds[$i];
                            $item2 = $productIds[$j];
                            $key = $item1 < $item2 ? "$item1-$item2" : "$item2-$item1";
    
                            if (!isset($itemSets[$key])) {
                                $itemSets[$key] = 0;
                            }
                            $itemSets[$key]++;
                        }
                    }
                }
    
                // Hitung frekuensi itemset 1-item
                $itemCounts = DB::table('transactions_items')
                    ->select('product_id', DB::raw('COUNT(DISTINCT transaction_id) as count'))
                    ->groupBy('product_id')
                    ->pluck('count', 'product_id')
                    ->toArray();
    
                // Ambil nama produk
                $productNames = DB::table('product')->pluck('name', 'id')->toArray();

                $dataRule=[];
    
                // Convert array to collection for easy manipulation
                $itemSets = collect($itemSets)->map(function ($count, $key) use ($totalTransactions, $productNames, $itemCounts) {
                    $products = explode('-', $key);
                    $productNamesArray = array_map(fn($id) => $productNames[$id] ?? 'Unknown', $products);
                    $support = ($count / $totalTransactions) * 100;
    
                    // Hitung confidence
                    $antecedent = $products[0];
                    $confidence = isset($itemCounts[$antecedent]) ? ($count / $itemCounts[$antecedent]) * 100 : 0;

                    //hapus data Pada Tabel RUle
                    Rule::truncate();

                    return [
                        'rule' => implode(' and ', $productNamesArray),
                        'support' => number_format($support, 2) . '%',
                        'confidence' => number_format($confidence, 2) . '%',
                    ];
                })->filter(function ($item) {
                    return $item['support'] >= 20 && $item['confidence'] > 60;
                })->sortByDesc('support');

    
                // Insert rules into the database
                foreach ($itemSets as $itemSet) {
                    Rule::create([
                        'rule' => $itemSet['rule'],
                        'support' => $itemSet['support'],
                        'confidence' => $itemSet['confidence'],
                    ]);
                }
                
                return DataTables::of($itemSets)
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }




    
    
}
