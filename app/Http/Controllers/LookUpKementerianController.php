<?php

namespace App\Http\Controllers;

use App\Models\LookupKementerian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LookUpKementerianController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LookupKementerian::orderBy('nama', 'ASC')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->is_active) {
                        return '<span class="badge badge-success">' . __('lookup_kementerian.Active') . '</span>';
                    } else {
                        return '<span class="badge badge-danger">' . __('lookup_kementerian.Inactive') . '</span>';
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
        
        return view('pages.lookup_kementerian');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $duplicate = LookupKementerian::where('nama', $request->nama)->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Kementerian sudah wujud');
        }

        LookupKementerian::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => true,
            'created_by' => User()->id,
        ]);

        flash('Kementerian berjaya ditambah', 'success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $lookup = LookupKementerian::findOrFail($id);
        return response()->json($lookup);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $lookup = LookupKementerian::findOrFail($id);
        
        $duplicate = LookupKementerian::where('nama', $request->nama)
                                     ->where('id', '!=', $id)
                                     ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Kementerian sudah wujud');
        }

        $lookup->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'updated_by' => User()->id,
        ]);

        flash('Kementerian berjaya dikemaskini', 'success');
        return redirect()->back();
    }

    public function toggleStatus(Request $request)
    {
        $lookup = LookupKementerian::findOrFail($request->id);
        $lookup->update([
            'is_active' => !$lookup->is_active,
            'updated_by' => User()->id,
        ]);

        $status = $lookup->is_active ? 'diaktifkan' : 'dinyahaktifkan';
        flash('Kementerian berjaya ' . $status, 'success');
        return redirect()->back();
    }
}
