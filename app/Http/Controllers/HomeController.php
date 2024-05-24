<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function dashboard() {
        return view('dashboard');
    }

    public function index(Request $request) {
        $data = new User;
        if ($request->get('search')) {
            $data = $data->where('name','like','%'. $request->get('search') .'%')
            ->orWhere('email', 'Like','%'. $request->get('search') .'%');
        }
        $data = $data->get();
        return view('index', compact('data', 'request'));
    }

    public function create() {
        return view('create');
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'photo' =>'required|mimes:png,jpg,jpeg|max:2048',
            'email'=> 'required|Email',
            'name'=> 'required',
            'password'=> 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        
        $photo      = $request->file('photo');
        $filename   = date('Y-m-d').$photo->getClientOriginalName();
        $path       = 'photo-user/'.$filename;

        Storage::disk('public')->put($path, file_get_contents($photo));
        
        // database
        $data['email']      = $request->email;
        $data['name']       = $request->name;
        $data['password']   = Hash::make($request->password);
        $data['image']      = $filename;

        User::create($data) ;
        return redirect()->route('admin.index');
    }

    public function edit($id) {
        $data = User::findOrFail($id);
        return view('edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'email'=> 'required|Email',
            'name'=> 'required',
            'password'=> 'nullable',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        
        // database
        $data['email'] = $request->email;
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        
        User::whereId( $id )->update($data);
        return redirect()->route('admin.index');
    }

    public function delete(Request $request, $id) {
        $data = User::findOrFail($id);
        if($data) {
            $data->delete();
        }
        return redirect()->route('admin.index');
    }
}
