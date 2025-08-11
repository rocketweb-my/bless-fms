<?php

namespace App\Http\Controllers;

use App\Models\LookupStatusLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LookUpStatusLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LookupStatusLog::orderBy('order', 'ASC')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('color_display', function ($data) {
                    return '<span class="badge" style="background-color: ' . $data->color . '; color: white;">' . $data->nama . '</span>';
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active) {
                        return '<span class="badge badge-success">' . __('lookup_status_log.Active') . '</span>';
                    } else {
                        return '<span class="badge badge-danger">' . __('lookup_status_log.Inactive') . '</span>';
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
                ->rawColumns(['color_display', 'status', 'created_date', 'action'])
                ->make(true);
        }
        
        return view('pages.lookup_status_log');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        $duplicate = LookupStatusLog::where('nama', $request->nama)->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Status Log sudah wujud');
        }

        // Auto-generate order
        $order = (LookupStatusLog::max('order') + 1);

        LookupStatusLog::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'color' => $request->color ?? '#6c757d',
            'order' => $order,
            'is_active' => true,
            'created_by' => User()->id,
        ]);

        flash('Status Log berjaya ditambah', 'success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $lookup = LookupStatusLog::findOrFail($id);
        return response()->json($lookup);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        $lookup = LookupStatusLog::findOrFail($id);
        
        $duplicate = LookupStatusLog::where('nama', $request->nama)
                                   ->where('id', '!=', $id)
                                   ->first();

        if ($duplicate != null) {
            return redirect()->back()->withErrors('Nama Status Log sudah wujud');
        }

        $lookup->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'color' => $request->color ?? '#6c757d',
            'updated_by' => User()->id,
        ]);

        flash('Status Log berjaya dikemaskini', 'success');
        return redirect()->back();
    }

    public function toggleStatus(Request $request)
    {
        $lookup = LookupStatusLog::findOrFail($request->id);
        $lookup->update([
            'is_active' => !$lookup->is_active,
            'updated_by' => User()->id,
        ]);

        $status = $lookup->is_active ? 'diaktifkan' : 'dinyahaktifkan';
        flash('Status Log berjaya ' . $status, 'success');
        return redirect()->back();
    }
}
