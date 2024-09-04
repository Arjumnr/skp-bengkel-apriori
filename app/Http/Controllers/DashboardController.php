<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rule;
use App\Models\Transactions;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tp = Product::count();
        $tr = Rule::count();
        $trs = Transactions::count();
        return view('dashboard', compact('tp', 'tr', 'trs'));
    }
}
