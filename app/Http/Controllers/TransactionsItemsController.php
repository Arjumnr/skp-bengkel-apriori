<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transactions;
use App\Models\TransactionsItems;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionsItemsController extends Controller
{
    public function index(Request $request){
        $data =  TransactionsItems::with(['getTransaction','getProduct'])->orderBy('id', 'DESC')->get();
        $products = Product::all();
        try {
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModal" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-sm edit"> <i class="menu-icon tf-icons  bx bx-edit"></i></a>';
                        // $btn =  $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="menu-icon tf-icons  bx bx-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.transaksi-item.index', compact('data', 'products'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function store(Request $request)
{
    try {
        // Ambil data_id jika ada
        $data_id = $request->data_id;

        // Extract total price and ensure it's a valid number
        $total_price = $request->total_price;
        $total_price = preg_replace('/[^\d]/', '', $total_price); // Remove everything except numbers
        $total_price = (int) $total_price; // Convert to integer

        // Step 1: Jika data_id ada, cari transaksi yang ada, jika tidak, buat transaksi baru
        if ($data_id) {
            // Update existing transaction
            $transaction_id = TransactionsItems::find($data_id)->transaction_id;
            $transaction = Transactions::find($transaction_id);
            if (!$transaction) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaksi tidak ditemukan.',
                ], 404);
            }

            // Hapus semua item transaksi terkait sebelum menyimpan ulang
            TransactionsItems::where('transaction_id', $transaction->id)->delete();

            // Reset total price to recalculate
            $transaction->total_price = 0;
            $transaction->save();
        } else {
            // Create new transaction
            $transaction = Transactions::create([
                'name' => $request->name,
                'total_price' => 0, // Initialize total price to zero, will update after calculating items
            ]);
        }

        $totalPrice = 0;

        // Step 2: Loop through each selected product and create/update transaction items
        foreach ($request->produk as $produkId) {
            // Find the product by its ID
            $product = Product::find($produkId);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Produk dengan ID {$produkId} tidak ditemukan.",
                ], 404);
            }

            // Get the quantity from the request or default to 1
            $quantity = intval($request->qty[$produkId] ?? 1);

            // Check if stock is sufficient
            if ($product->stock < $quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Stok untuk produk {$product->name} tidak mencukupi.",
                ], 400);
            }

            // Calculate total price for the items
            $itemTotalPrice = $quantity * $product->sell;

            // Update total price for the transaction
            $totalPrice += $itemTotalPrice;

            // Create or update transaction items
            TransactionsItems::updateOrCreate(
                [
                    'product_id' => $produkId,
                    'transaction_id' => $transaction->id,
                ],
                [
                    'qty' => $quantity,
                    'price' => $itemTotalPrice,
                ]
            );

            // Update product stock
            $product->stock -= $quantity;
            $product->save();
        }

        // Step 3: Update total price of the transaction
        $transaction->update(['total_price' => $totalPrice]);

        // Return a successful response
        return response()->json([
            'data' => $transaction,
            'status' => 'success',
            'message' => 'Data transaksi berhasil disimpan.',
        ]);
    } catch (\Exception $e) {
        // Catch and return any errors
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}





    public function edit($id)
    {
        $data = TransactionsItems::find($id);
        //get trasanction_id 
        $transaction_id = $data->transaction_id;
        $data = TransactionsItems::where('transaction_id', $transaction_id)->get();
        $transaction = Transactions::find($transaction_id);
        $data = [
            'data' => $data,
            'transaction' => $transaction
        ];
        return response()->json($data);
    }


    public function destroy($id)
    {
        try {
            TransactionsItems::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
