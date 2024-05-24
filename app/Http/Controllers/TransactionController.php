<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // show all product
    public function index(Request $request){
        $data = new Product();
        if ($request->get('search')) {
            $data = $data->where('name','like','%'. $request->get('search') .'%');
        }
        $data = $data->get();
        return view('transaction.index', compact('data', 'request'));
    }

    public function store(Request $request)
    {
        $transaksi = new Transaction();
        $transaksi->fill([
            'user_id' => Auth::id(),
            'total_harga' => $request->get('total_harga')
        ]);
        // dd($transaksi);
        $transaksi->save();
        $no_daftar = 0;
        foreach ($request->get('id_daftar') as $id_daftar) {
            $daftar = Product::findOrFail($id_daftar);
            $transaksi_item = new TransactionItem();
            $transaksi_item->fill([
                'id_transaksi' => $transaksi->id,
                'id_daftar' => $id_daftar,
                'nama' => $daftar->name,
                'harga' => $daftar->price,
                'quantity' => $request->get('quantity')[$no_daftar]
            ]);
            $transaksi_item->save();
            $no_daftar++;
        }
        return redirect()->back();
    }

    // insert product to table
    // public function insert($id) {
    //     $data = Product::findOrFail($id);
    //     $name = $data->name;
    //     $price = $data->price;
    //     $quantity = 1;

    //     $dataObjects = [];
    //     $dataObjects[] = (object) [
    //         'name' => $name,
    //         'price' => $price,
    //         'quantity'=> $quantity
    //     ];
    //     // dd($dataObjects);
    //     return view('transaction.index',['dataObjects' => $dataObjects]);
    // }

    // public function show_cart(Request $request) {
    //     $data = [];
    // }

    // delete product from table

    // total price product
}
