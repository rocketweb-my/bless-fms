<?php

namespace App\Http\Controllers;

use App\Models\LookupLesen;
use App\Models\LookupAgensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LookUpLesenController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LookupLesen::with('agensi')->orderBy('nama', 'ASC')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('agensi_nama', function ($data) {
                    return $data->agensi ? $data->agensi->nama : '-';
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
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
                ->rawColumns(['status', 'created_date', 'action'])
                ->make(true);
        }
        
        $agensi = LookupAgensi::where('is_active', 1)->orderBy('nama', 'ASC')->get();
        return view('pages.lookup_lesen', compact('agensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'penerangan' => 'nullable|string',
            'agensi_id' => 'required|exists:lookup_agensi,id',
        ]);

        $duplicate = LookupLesen::where('nama', $request->nama)
                               ->where('agensi_id', $request->agensi_id)
                               ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Lesen untuk Agensi ini sudah wujud');
        }

        LookupLesen::create([
            'nama' => $request->nama,
            'penerangan' => $request->penerangan,
            'agensi_id' => $request->agensi_id,
            'is_active' => true,
        ]);

        flash('Lesen berjaya ditambah', 'success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $lookup = LookupLesen::with('agensi')->findOrFail($id);
        return response()->json($lookup);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'penerangan' => 'nullable|string',
            'agensi_id' => 'required|exists:lookup_agensi,id',
        ]);

        $lookup = LookupLesen::findOrFail($id);
        
        $duplicate = LookupLesen::where('nama', $request->nama)
                               ->where('agensi_id', $request->agensi_id)
                               ->where('id', '!=', $id)
                               ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Lesen untuk Agensi ini sudah wujud');
        }

        $lookup->update([
            'nama' => $request->nama,
            'penerangan' => $request->penerangan,
            'agensi_id' => $request->agensi_id,
        ]);

        flash('Lesen berjaya dikemaskini', 'success');
        return redirect()->back();
    }

    public function toggleStatus(Request $request)
    {
        $lookup = LookupLesen::findOrFail($request->id);
        $lookup->update([
            'is_active' => !$lookup->is_active,
        ]);

        $status = $lookup->is_active ? 'diaktifkan' : 'dinyahaktifkan';
        flash('Lesen berjaya ' . $status, 'success');
        return redirect()->back();
    }

    // API method to get Lesen by Agensi ID
    public function getLesenByAgensi($agensiId)
    {
        $lesen = LookupLesen::where('agensi_id', $agensiId)
                           ->where('is_active', 1)
                           ->orderBy('nama', 'ASC')
                           ->get();
        
        return response()->json($lesen);
    }
}
