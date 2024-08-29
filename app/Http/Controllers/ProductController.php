<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request){
        $data =  Product::orderBy('id','DESC')->get();
        $data =  Product::all();
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
            // return response()->json(['data' => $data]);
            return view('admin.produk.index', compact('data'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            Product::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'name' => $request->name,
                    'stock' => $request->stock,
                    'capital' => $request->capital,
                    'sell' => $request->sell,

                ]
            );
            return response()->json(['data' => $request->all(), 'status' => 'success', 'message' => 'Save data successfully.', ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
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
            Product::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
