<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RuleController extends Controller
{
    public function index(Request $request){
        $data = Rule::with('get_product')->orderBy('id', 'DESC')->get();
        $nameProduct = [];
        
        $dataProduk =  Product::all();
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
            // return response()->json(['data' => $data, 'dataProduk' => $dataProduk]);
            return view('admin.rule.index', compact('data', 'dataProduk'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            // Dapatkan produk yang dipilih dari request
            $selectedProducts = $request->input('produk', []);
            
            // Gabungkan ID produk yang dipilih sebagai string (misalnya '1,2,3') atau simpan sebagai array jika diinginkan
            $rule = implode(',', $selectedProducts);
    
            // Update atau create data dengan field sesuai
            Rule::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'rule' => $rule, // Menyimpan rule sebagai string ID produk
                    'support' => $request->support,
                    'confidence' => $request->confidence,
                ]
            );
    
            return response()->json([
                'data' => $request->all(),
                'status' => 'success',
                'message' => 'Data berhasil disimpan.',
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
        $data = Rule::find($id);
        $dataProduk =  Product::all();
        return response()->json(['data' => $data, 'dataProduk' => $dataProduk]);
    }


    public function destroy($id)
    {
        try {
            Rule::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
