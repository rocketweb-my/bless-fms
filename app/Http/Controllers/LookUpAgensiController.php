<?php

namespace App\Http\Controllers;

use App\Models\LookupAgensi;
use App\Models\LookupKementerian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LookUpAgensiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LookupAgensi::with('kementerian')->orderBy('nama', 'ASC')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kementerian_nama', function ($data) {
                    return $data->kementerian ? $data->kementerian->nama : '-';
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active) {
                        return '<span class="badge badge-success">' . __('lookup_agensi.Active') . '</span>';
                    } else {
                        return '<span class="badge badge-danger">' . __('lookup_agensi.Inactive') . '</span>';
                    }
                })
                ->addColumn('created_date', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($data) {
                    $btn = '<button class="btn btn-icon btn-success" data-id="'.$data->id.'" id="edit"><i class="fa fa-pencil-square-o"></i></button>';
                    
                    if ($data->is_active) {
                        $btn = $btn.'&nbsp; <button class="btn btn-icon btn-warning" data-id="'.$data->id.'" id="disable"><i class="fa fa-ban"></i></button>';
                    } else {
                        $btn = $btn.'&nbsp; <button class="btn btn-icon btn-success" data-id="'.$data->id.'" id="enable"><i class="fa fa-check"></i></button>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['kementerian_nama', 'status', 'created_date', 'action'])
                ->make(true);
        }
        
        $kementerians = LookupKementerian::where('is_active', true)->orderBy('nama', 'ASC')->get();
        return view('pages.lookup_agensi', compact('kementerians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kementerian_id' => 'required|exists:lookup_kementerian,id',
            'deskripsi' => 'nullable|string',
        ]);

        $duplicate = LookupAgensi::where('nama', $request->nama)
                                 ->where('kementerian_id', $request->kementerian_id)
                                 ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Agensi untuk Kementerian ini sudah wujud');
        }

        LookupAgensi::create([
            'nama' => $request->nama,
            'kementerian_id' => $request->kementerian_id,
            'deskripsi' => $request->deskripsi,
            'is_active' => true,
            'created_by' => User()->id,
        ]);

        flash('Agensi berjaya ditambah', 'success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $lookup = LookupAgensi::with('kementerian')->findOrFail($id);
        return response()->json($lookup);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kementerian_id' => 'required|exists:lookup_kementerian,id',
            'deskripsi' => 'nullable|string',
        ]);

        $lookup = LookupAgensi::findOrFail($id);
        
        $duplicate = LookupAgensi::where('nama', $request->nama)
                                 ->where('kementerian_id', $request->kementerian_id)
                                 ->where('id', '!=', $id)
                                 ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Agensi untuk Kementerian ini sudah wujud');
        }

        $lookup->update([
            'nama' => $request->nama,
            'kementerian_id' => $request->kementerian_id,
            'deskripsi' => $request->deskripsi,
            'updated_by' => User()->id,
        ]);

        flash('Agensi berjaya dikemaskini', 'success');
        return redirect()->back();
    }

    public function toggleStatus(Request $request)
    {
        $lookup = LookupAgensi::findOrFail($request->id);
        $lookup->update([
            'is_active' => !$lookup->is_active,
            'updated_by' => User()->id,
        ]);

        $status = $lookup->is_active ? 'diaktifkan' : 'dinyahaktifkan';
        flash('Agensi berjaya ' . $status, 'success');
        return redirect()->back();
    }

    public function getAgensiByKementerian($kementerianId)
    {
        $agensi = LookupAgensi::where('kementerian_id', $kementerianId)
                              ->where('is_active', 1)
                              ->orderBy('nama', 'ASC')
                              ->get(['id', 'nama']);
        return response()->json($agensi);
    }

    public function getAgensiDetails($agensiId)
    {
        $agensi = LookupAgensi::find($agensiId);

        if (!$agensi) {
            return response()->json(['error' => 'Agensi not found'], 404);
        }

        return response()->json([
            'id' => $agensi->id,
            'nama' => $agensi->nama,
            'negeri_nama' => $agensi->negeri ?? '',
            'cawangan' => $agensi->cawangan ?? '',
        ]);
    }
}
