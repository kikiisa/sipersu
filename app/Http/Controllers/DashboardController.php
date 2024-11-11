<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $arsip = new Arsip();
        $data_bulan_ini = Arsip::whereMonth('created_at', date('m'))->count();
        $total_arsip = $arsip->count();
        $pdf = $arsip->where('type', 'pdf')->count();
        $doc = $arsip->where('type', 'docx')->count();
        $xls = $arsip->where('type', 'xlsx')->count();
        $pptx = $arsip->where('type', 'pptx')->count();


        if (Auth::user()->role == "pegawai") {
            $data = Arsip::with('kategori')->paginate(5);
            if ($request->has('q')) {
                $data = Arsip::with('kategori')->where('judul', 'like', '%' . $request->q . '%')->paginate(5);
            }
            return response()->view("users.dashboard", [
                'pdf' => $pdf,
                'doc' => $doc,
                'xls' => $xls,
                'pptx' => $pptx,
                'arsip' => $data
            ]);
        }

        return response()->view("admin.dashboard.index", [
            'data_bulan_ini' => $data_bulan_ini,
            'total_arsip' => $total_arsip,
            'pdf' => $pdf,
            'doc' => $doc,
            'xls' => $xls,
            'pptx' => $pptx
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
