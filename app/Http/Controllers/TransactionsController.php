<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionsItems;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionsController extends Controller
{
    public function index(Request $request){
        $data =  Transactions::all();
        try {
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn =  ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="menu-icon tf-icons  bx bx-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.transaksi.index', compact('data'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            TransactionsItems::updateOrCreate(
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
        $data = TransactionsItems::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        try {
            Transactions::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
