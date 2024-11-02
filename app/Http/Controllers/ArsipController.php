<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ArsipController extends Controller
{
    private $folder = "data/arsip/";
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Arsip::with('kategori')->paginate(5);
        $kategori = Kategori::all();
        if($request->has('q')){
           $data = Arsip::with('kategori')->where('judul','like','%'.$request->q.'%')->paginate(5);
        }
        return response()->view("admin.arsip.index",compact("kategori","data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();     
        return response()->view("admin.arsip.create",compact("kategori"));  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        $file = $request->file('file');
        $fileName = $file->hashName();
        $file->move($this->folder, $fileName);

        $data = [
            'uuid' => Uuid::uuid4()->toString(),
            'judul' => $request->title,
            'file' => $fileName,
            'kategori_id' => $request->kategori,
            'keterangan' => $request->deskripsi
        ];
        $data = Arsip::create($data);
        return redirect()->route('arsip.index')->with("success", "Data Berhasil Disimpan");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
