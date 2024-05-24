<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request) {
        $data = new Product();
        if ($request->get('search')) {
            $data = $data->where('name','like','%'. $request->get('search') .'%')
            ->orWhere('email', 'Like','%'. $request->get('search') .'%');
        }
        $data = $data->get();
        return view('product.index', compact('data', 'request'));
    }

    public function create() {
        return view('product.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'stock'=> 'required',
            'price'=> 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        
        // database
        $data['name']       = $request->name;
        $data['stock']      = $request->stock;
        $data['price']      = $request->price;

        Product::create($data) ;
        return redirect()->route('admin.product');
    }

    public function edit($id) {
        $data = Product::findOrFail($id);
        return view('product.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'stock'=> 'required',
            'price'=> 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        
        // database
        $data['name'] = $request->name;
        $data['stock'] = $request->stock;
        $data['price'] = $request->price;

        
        Product::whereId( $id )->update($data);
        return redirect()->route('admin.product');
    }

    public function delete(Request $request, $id) {
        $data = Product::findOrFail($id);
        if($data) {
            $data->delete();
        }
        return redirect()->route('admin.product');
    }
}
