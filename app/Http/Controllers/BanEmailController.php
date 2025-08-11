<?php

namespace App\Http\Controllers;

use App\Models\BanEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BanEmailController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
            $data = BanEmail::orderBy('email', 'ASC')->get();
            //Datatable

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('ban_by', function ($data) {

                    $banned_by = findUser($data->banned_by);
                    if ($banned_by == null)
                    {
                        return '';
                    }
                    else{
                        return $banned_by->name;
                    }
                })
                ->addColumn('date', function ($data) {
                    return Carbon::parse($data->dt)->format('d-m-Y H:m:s');
                })
                ->addColumn('action', function ($data) {
                    if(user()->isadmin == 1 ||userPermissionChecker('can_unban_emails') == true)
                    {
                        $link = '<button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';

                    }else{
                        $link = '';
                    }
                    return $link;
                })


                ->rawColumns(['ban_by','date','action'])
                ->make(true);
        }
        return view('pages.ban_email');

    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required',
        ]);

        // Get the email
        $email = strtolower($request->email);

        // Only allow one email to be entered
        $email = ($index = strpos($email, ',')) ? substr($email, 0,  $index) : $email;
        $email = ($index = strpos($email, ';')) ? substr($email, 0,  $index) : $email;

        $duplicate_email = BanEmail::where('email', $email)->first();

        if ($duplicate_email != null)
        {
            return redirect()->back()->withErrors('Email Already Banned');
        }

        BanEmail::create([
           'email'  => $email,
            'banned_by' => User()->id,
        ]);

        // toastr()->success('Email Successfully Banned', 'Success');
        flash('Email Successfully Banned', 'success');
        return redirect()->back();
    }

    public function store_from_reply_page(Request $request){
        $request->validate([
            'email' => 'required',
        ]);

        // Get the email
        $email = strtolower($request->email);

        // Only allow one email to be entered
        $email = ($index = strpos($email, ',')) ? substr($email, 0,  $index) : $email;
        $email = ($index = strpos($email, ';')) ? substr($email, 0,  $index) : $email;

        $duplicate_email = BanEmail::where('email', $email)->first();

        if ($duplicate_email != null)
        {
            return redirect()->back()->withErrors('Email Already Banned');
        }

        BanEmail::create([
            'email'  => $email,
            'banned_by' => User()->id,
        ]);

        // toastr()->success('Email Successfully Banned', 'Success');
        flash('Email Successfully Banned', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function delete(Request $request)
    {
        $email = BanEmail::find($request->id);
        $email->delete();

        // toastr()->success('Email Successfully Deleted', 'Success');
        flash('Email Successfully Deleted', 'success');
        return redirect()->back();
    }
}
