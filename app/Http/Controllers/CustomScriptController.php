<?php

namespace App\Http\Controllers;

use App\Models\CustomScript;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomScriptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CustomScript::orderBy('created_at', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('location', function ($data) {
                    return ucfirst($data->location);
                })
                ->addColumn('page', function ($data) {
                    return $data->page == 'feedback_form' ? 'Feedback Submission Form' : 'All Pages';
                })
                ->addColumn('status', function ($data) {
                    return $data->status ? 'Active' : 'Inactive';
                })
                ->addColumn('action', function ($data) {
                    $btn = '<button class="btn btn-icon btn-success" data-id="'.$data->id.'" id="edit"><i class="fa fa-pencil-square-o"></i></button>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.custom_script');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'location' => 'required|in:head,body',
            'page' => 'required|in:feedback_form,all_pages',
            'script_content' => 'required',
            'status' => 'required|boolean',
        ]);

        CustomScript::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'page' => $request->page,
            'script_content' => $request->script_content,
            'status' => $request->status,
        ]);

        flash('Custom Script Successfully Created', 'success');
        return redirect()->back();
    }

    public function get_data(Request $request)
    {
        $custom_script = CustomScript::find($request->id);
        return response()->json($custom_script);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'location' => 'required|in:head,body',
            'page' => 'required|in:feedback_form,all_pages',
            'script_content' => 'required',
            'status' => 'required|boolean',
        ]);

        $custom_script = CustomScript::find($request->id);

        $custom_script->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'page' => $request->page,
            'script_content' => $request->script_content,
            'status' => $request->status,
        ]);

        flash('Custom Script Successfully Updated', 'success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $custom_script = CustomScript::find($id);
        $custom_script->delete();

        flash('Custom Script Successfully Deleted', 'success');
        return response()->json(['success' => 'Ajax request submitted successfully']);
    }
}
