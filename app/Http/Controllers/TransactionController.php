<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

   public function store(Request $request){
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
