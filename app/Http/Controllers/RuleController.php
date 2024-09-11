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
                    ->select('product.name as product_name', DB::raw('COUNT(transactions_items.qty) as purchase_count'))
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
                    ->select('product.name as itemset', DB::raw('COUNT(transactions_items.qty) as qty'))
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

    public function kombinasiItemset(Request $request)
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

                    // Buat kombinasi item dengan panjang dari 2 sampai n
                    for ($size = 2; $size <= $count; $size++) {
                        $combinations = $this->getCombinations($productIds, $size);
                        foreach ($combinations as $combination) {
                            sort($combination); // Sort untuk memastikan konsistensi kunci
                            $key = implode('-', $combination);

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
                        'itemset' => implode(' && ', $productNamesArray),
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
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'line' => $e->getLine()]);
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

                // Hitung frekuensi kombinasi item dengan ukuran dari 2 sampai n
                foreach ($transactions as $transaction) {
                    $productIds = $transaction->pluck('product_id')->toArray();
                    $count = count($productIds);

                    for ($size = 2; $size <= $count; $size++) {
                        $combinations = $this->getCombinations($productIds, $size);
                        foreach ($combinations as $combination) {
                            sort($combination); // Sort untuk memastikan konsistensi kunci
                            $key = implode('-', $combination);

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

                // Hapus data lama dari tabel Rule
                Rule::truncate();

                // Hitung support dan confidence untuk itemset
                $itemSets = collect($itemSets)->map(function ($count, $key) use ($totalTransactions, $productNames, $itemCounts) {
                    $products = explode('-', $key);
                    $productNamesArray = array_map(fn($id) => $productNames[$id] ?? 'Unknown', $products);
                    $support = ($count / $totalTransactions) * 100;

                    // Format support
                    $supportFormatted = "{$count}/{$totalTransactions} x 100% = " . number_format($support, 2) . "%";

                    // Hitung confidence hanya untuk itemset yang "Join"
                    $antecedent = $products[0];
                    $antecedentCount = isset($itemCounts[$antecedent]) ? $itemCounts[$antecedent] : $count;
                    $confidence = ($antecedentCount > 0) ? ($count / $antecedentCount) * 100 : 0;

                    // Format confidence
                    $confidenceFormatted = "{$count}/{$antecedentCount} x 100% = " . number_format($confidence, 2) . "%";

                    return [
                        'rule' => implode(' && ', $productNamesArray),
                        'support' => $supportFormatted,
                        'confidence' => $confidenceFormatted,
                    ];
                })->filter() // Hapus itemset yang tidak valid
                ->sortByDesc('support' . ' ' . 'confidence');

                // Simpan aturan ke database
                foreach ($itemSets as $itemSet) {
                    Rule::updateOrCreate(
                        ['rule' => $itemSet['rule']],
                        [
                            'support' => $itemSet['support'],
                            'confidence' => $itemSet['confidence'],
                        ]
                    );
                }

                return DataTables::of($itemSets)
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    
    

     /**
     * Menghasilkan kombinasi dari itemset
     *
     * @param array $items
     * @param int $size
     * @return array
     */
    private function getCombinations(array $items, int $size)
    {
        $result = [];

        if ($size == 1) {
            foreach ($items as $item) {
                $result[] = [$item];
            }
        } else {
            for ($i = 0; $i < count($items) - $size + 1; $i++) {
                $item = $items[$i];
                $remainingItems = array_slice($items, $i + 1);
                foreach ($this->getCombinations($remainingItems, $size - 1) as $combination) {
                    $result[] = array_merge([$item], $combination);
                }
            }
        }

        return $result;
    }
    




    
    
}
