<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $data = Kategori::paginate(5);
        $kategori = Kategori::all();
        if($request->has('q')){
            $data = Kategori::where('name','like','%'.$request->q.'%')->paginate(5);
        }
        return response()->view("admin.kategori.index",compact("kategori","data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view("admin.kategori.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ],[
            'title.required' => 'Kategori Tidak Boleh Kosong'
        ]);
        
        $data = Kategori::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $request->title,
            'slug' => Str::slug($request->title),
        ]);
        return redirect()->route("kategori.index")->with("success","Data Berhasil Disimpan");
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::all()->where("uuid",$id)->first();
        return response()->view("admin.kategori.edit",compact("kategori"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate([
            'title' => 'required',
        ],[
            'title.required' => 'Kategori Tidak Boleh Kosong'
        ]);
        $kategori->update([
            'name' => $request->title,
            'slug' => Str::slug($request->title),
        ]);
        return redirect()->route("kategori.index")->with("success","Data Berhasil Diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cari data arsip berdasarkan kategori
        $data = Kategori::findOrFail($id);   
        
        // ubah kategori arsip
        $arsip = Arsip::where("kategori_id", $id)->update(['kategori_id' => 1]);

        if($data->name == "default")
        {
            return redirect()->route("kategori.index")->with("error","Data Default Tidak Dapat Dihapus");
        }
        $data->delete();
        return redirect()->route("kategori.index")->with("success","Data Berhasil Dihapus");
    
    }
}
