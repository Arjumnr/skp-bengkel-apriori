<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TransactionsItems;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionsItemsController extends Controller
{
    public function index(Request $request){
        $data =  TransactionsItems::all();
        $products = Product::all();
        try {
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModal" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-sm edit"> <i class="menu-icon tf-icons  bx bx-edit"></i></a>';
                        $btn =  $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="menu-icon tf-icons  bx bx-trash"></i></a>';
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
        //     Product::updateOrCreate(
        //         ['id' => $request->data_id],
        //         [
        //             'name' => $request->name,
        //             'stock' => $request->stock,
        //             'capital' => $request->capital,
        //             'sell' => $request->sell,
        //         ]
        //     );
        //     return response()->json(['data' => $request->all(), 'status' => 'success', 'message' => 'Save data successfully.', ]);
        // } catch (\Exception $e) {
        //     return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        // }

            // Simpan transaksi baru
            foreach ($request->produk as $key => $produkId) {

                $product = Product::find($produkId);

                $quantity = $request->qty[$produkId] ?? 1; // Default ke 1 jika qty tidak ada


                // Cek stok
                if ($product->stock < $quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Stok untuk produk {$product->name} tidak mencukupi."
                    ]);
                }

                // Buat atau perbarui item transaksi
                TransactionsItems::updateOrCreate(
                    ['product_id' => $produkId, 'transaction_id' => $request->data_id],
                    [
                        'transaction_id' => $request->transaction_id,
                        'product_id' => $request->product_id,
                        'qty' => $product->qty,
                        'price' => $product->price,
                    ]
                );

                // Update stok produk
                $product->stock -= $quantity;
                $product->save();
            }

            return response()->json([
                'data' => $request->all(),
                'status' => 'success',
                'message' => 'Data transaksi berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $data = Product::find($id);
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
