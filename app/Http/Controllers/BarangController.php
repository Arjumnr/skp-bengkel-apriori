<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request){
        $data =  Barang::orderBy('stok', 'desc')->get();
        $provider = Provider::all();
        try {
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#basicModal" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm edit"> <i class="menu-icon tf-icons  bx bx-edit"></i></a>';
                        $btn =  $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="menu-icon tf-icons  bx bx-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.barang.index', compact('data', 'provider'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            // return response()->json(['data' => $request->all()]);
            if (  $request->file('gambar')) {
                $file =  $request->file('gambar');
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/img/barang/', $name);
            }else {
                $dataBarang = Barang::find($request->data_id);
                $name = $dataBarang->gambar;
            }

            

            Barang::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'nama_barang' => $request->nama_barang,
                    'gambar' => $name,
                    'kategori' => $request->kategori,
                    'modal' => $request->modal,
                    'harga' => $request->harga,
                    'stok' => $request->stok,

                ]
            );
            return response()->json(['data' => $request->all(), 'status' => 'success', 'message' => 'Save data successfully.', ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $dataUser = Barang::find($id);
        return response()->json($dataUser);
    }


    public function destroy($id)
    {
        try {
            Barang::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
