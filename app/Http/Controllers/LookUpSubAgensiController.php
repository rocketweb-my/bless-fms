<?php

namespace App\Http\Controllers;

use App\Models\LookupSubAgensi;
use App\Models\LookupAgensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LookUpSubAgensiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LookupSubAgensi::with(['agensi', 'agensi.kementerian'])->orderBy('nama', 'ASC')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('agensi_nama', function ($data) {
                    return $data->agensi ? $data->agensi->nama : '-';
                })
                ->addColumn('kementerian_nama', function ($data) {
                    return ($data->agensi && $data->agensi->kementerian) ? $data->agensi->kementerian->nama : '-';
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active) {
                        return '<span class="badge badge-success">' . __('lookup_sub_agensi.Active') . '</span>';
                    } else {
                        return '<span class="badge badge-danger">' . __('lookup_sub_agensi.Inactive') . '</span>';
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
                ->rawColumns(['agensi_nama', 'kementerian_nama', 'status', 'created_date', 'action'])
                ->make(true);
        }
        
        $agensis = LookupAgensi::with('kementerian')->where('is_active', true)->orderBy('nama', 'ASC')->get();
        return view('pages.lookup_sub_agensi', compact('agensis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'agensi_id' => 'required|exists:lookup_agensi,id',
            'deskripsi' => 'nullable|string',
        ]);

        $duplicate = LookupSubAgensi::where('nama', $request->nama)
                                   ->where('agensi_id', $request->agensi_id)
                                   ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Sub Agensi untuk Agensi ini sudah wujud');
        }

        LookupSubAgensi::create([
            'nama' => $request->nama,
            'agensi_id' => $request->agensi_id,
            'deskripsi' => $request->deskripsi,
            'is_active' => true,
            'created_by' => User()->id,
        ]);

        flash('Sub Agensi berjaya ditambah', 'success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $lookup = LookupSubAgensi::with(['agensi', 'agensi.kementerian'])->findOrFail($id);
        return response()->json($lookup);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'agensi_id' => 'required|exists:lookup_agensi,id',
            'deskripsi' => 'nullable|string',
        ]);

        $lookup = LookupSubAgensi::findOrFail($id);
        
        $duplicate = LookupSubAgensi::where('nama', $request->nama)
                                   ->where('agensi_id', $request->agensi_id)
                                   ->where('id', '!=', $id)
                                   ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Sub Agensi untuk Agensi ini sudah wujud');
        }

        $lookup->update([
            'nama' => $request->nama,
            'agensi_id' => $request->agensi_id,
            'deskripsi' => $request->deskripsi,
            'updated_by' => User()->id,
        ]);

        flash('Sub Agensi berjaya dikemaskini', 'success');
        return redirect()->back();
    }

    public function toggleStatus(Request $request)
    {
        $lookup = LookupSubAgensi::findOrFail($request->id);
        $lookup->update([
            'is_active' => !$lookup->is_active,
            'updated_by' => User()->id,
        ]);

        $status = $lookup->is_active ? 'diaktifkan' : 'dinyahaktifkan';
        flash('Sub Agensi berjaya ' . $status, 'success');
        return redirect()->back();
    }
}
