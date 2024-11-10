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
            'type' => $file->getClientOriginalExtension(),
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
        $arsip = Arsip::with('kategori')->where('uuid', $id)->first();
        return response()->download($this->folder . $arsip->file);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::all();
        $arsip = Arsip::with('kategori')->where('uuid', $id)->first();
        
        return response()->view("admin.arsip.detail",compact("kategori","arsip"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $arsip = Arsip::findOrFail($id);
        if($request->hasFile('file')){
            $request->validate([
                'title' => 'required',
                'file' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:2048',
                'kategori' => 'required',
                'deskripsi' => 'required',
                

            ]);
            if($arsip->file != null){
                $path = $this->folder . $arsip->file;
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $file = $request->file('file');
            $fileName = $file->hashName();
            $file->move($this->folder, $fileName);
            $data = [
                'judul' => $request->title,
                'file' => $fileName,
                'kategori_id' => $request->kategori,
                'keterangan' => $request->deskripsi,
                'type' => $file->getClientOriginalExtension()
            ];
            $arsip->update($data);
            return redirect()->route('arsip.index')->with("success", "Data Berhasil Di Updated");
        }else{
            $request->validate([
                'title' => 'required',
                'kategori' => 'required',
                'deskripsi' => 'required',
            ]);
            $arsip->update([
                'judul' => $request->title,
                'kategori_id' => $request->kategori,
                'keterangan' => $request->deskripsi
            ]);
            return redirect()->route('arsip.index')->with("success", "Data Berhasil Diupdate");
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arsip = Arsip::findOrFail($id);
        if($arsip->file != null){
            $path = $this->folder . $arsip->file;
            if(file_exists($path)){
                unlink($path);
            }
        }
        $arsip->delete();
        return redirect()->route('arsip.index')->with("success", "Data Berhasil Dihapus");
    }
}
