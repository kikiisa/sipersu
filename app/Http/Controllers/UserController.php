<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = User::paginate(5);
        if($request->has('q')){
            $data = User::where('name','like','%'.$request->q.'%')->paginate(5);
        }
        return response()->view("admin.user.index", compact("data"));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view("admin.user.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = new User();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required',
            'confirm' => 'required|same:password'
        ]);
        $data->create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password), 
        ]);
        return redirect()->route('user.index')->with("success", "Data Berhasil Di Tambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::all()->where("uuid",$id)->first();
        return response()->view("admin.user.edit",compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = User::find($id);
        if($request->password != null){
            
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'password' => 'required',
                'confirm' => 'required|same:password'
            ]);
            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password), 
            ]);
            return redirect()->route('user.index')->with("success", "Data Berhasil Update");
        }else{

            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ]);
            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
            return redirect()->route('user.index')->with("success", "Data Berhasil Update");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        if($data->id == Auth::user()->id){
            return redirect()->route('user.index')->with("error", "Akun Tidak Dapat Dihapus");
        }
        $data->delete();
        return redirect()->route('user.index')->with("success", "Data Berhasil Dihapus");
    }
}
