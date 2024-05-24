<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request) {
        $data = Transaction::all();
        return view('report.index', compact('data'));
    }
    public function delete($id)
    {
        $transaksi = Transaction::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('admin.report');
    }
}
