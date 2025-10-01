<?php

namespace App\Http\Controllers;

use App\Models\PersonInCharge;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PersonInChargeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //Datatable
            $data = PersonInCharge::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<form method="post" action="'.route('personincharge.edit').'" id="pic'.$data->id.'"><input type="hidden" name="_token" value="'.csrf_token().'" /><input type="hidden" name="id" value="'.$data->id.'"></form>';
                    $btn = $btn.'<button class="btn btn-icon btn-success" type="submit" form="pic'.$data->id.'"><i class="fa fa-pencil-square-o"></i></button>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.personincharge.index');
    }

    public function create()
    {
        return view('pages.personincharge.add_edit');
    }

    public function edit(Request $request)
    {
        $personInCharge = PersonInCharge::find($request->id);
        return view('pages.personincharge.add_edit', compact('personInCharge'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'kementerian_id' => 'required|exists:lookup_kementerian,id',
            'agensi_id' => 'required|exists:lookup_agensi,id',
        ]);

        PersonInCharge::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone_number'      => $request->phone_number,
            'kementerian_id'    => $request->kementerian_id,
            'agensi_id'         => $request->agensi_id,
        ]);

        flash('Person In Charge Successfully Added', 'success');
        return redirect()->route('personincharge.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'kementerian_id' => 'required|exists:lookup_kementerian,id',
            'agensi_id' => 'required|exists:lookup_agensi,id',
        ]);

        $personInCharge = PersonInCharge::find($request->id);
        $personInCharge->name = $request->name;
        $personInCharge->email = $request->email;
        $personInCharge->phone_number = $request->phone_number;
        $personInCharge->kementerian_id = $request->kementerian_id;
        $personInCharge->agensi_id = $request->agensi_id;
        $personInCharge->save();

        flash('Person In Charge Successfully Updated', 'success');
        return redirect()->route('personincharge.index');
    }

    public function destroy(Request $request)
    {
        $personInCharge = PersonInCharge::find($request->id);
        $personInCharge->delete();
        flash('Person In Charge Successfully Deleted', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
}
