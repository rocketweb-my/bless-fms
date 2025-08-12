<?php

namespace App\Http\Controllers;

use App\Mail\Staff\UserCreated;
use App\Models\Category;
use App\Models\ReplyDraft;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //Datatable
            $data = User::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

//                    $btn = '<form action='.route('team.profile').' method="post" id="edit'.$data->id.'"><input type="hidden" name="_token" value='.csrf_token().'><input type="hidden" name="id" value='.$data->id.'></form><button type="submit" class="btn btn-icon btn-success" form="edit'.$data->id.'"><i class="fa fa-pencil-square-o"></i></button>';
                    if($data->is_active == 1){
                        $btn = '<button class="btn btn-icon btn-info" data-id="'.$data->id.'" id="status"><i class="fa fa-pause"></i></button>';
                    }else{
                        $btn = '<button class="btn btn-icon btn-warning" data-id="'.$data->id.'" id="status"><i class="fa fa-play"></i></button>';
                    }
                    $btn = $btn.'&nbsp; <a href='.route('team.profile', $data->id).' class="btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';

                    return $btn;
                })

                ->addColumn('autoassign_edit', function ($data) {

                    if ($data->autoassign == 0)
                    {
                        $autoassign = '<label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" disabled>
                                            <span class="custom-switch-indicator"></span>
                                        </label>';
                    }else
                    {
                        $autoassign = '<label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled>
                                            <span class="custom-switch-indicator"></span>
                                        </label>';
                    }

                    return $autoassign;
                })

                ->addColumn('isadmin_edit', function ($data) {

                    if ($data->isadmin == 1)
                    {
                        $type = '<span class="badge badge-primary  mr-1 mb-1 mt-1">Administrator</span>';
                    }else
                    {
                        $type = '<span class="badge badge-info mr-1 mb-1 mt-1">Staff</span>';
                    }

                    return $type;
                })

                ->addColumn('is_active', function ($data) {
                    return $data->is_active == 1 ? '<span class="badge badge-success">'.__('team.Active').'</span>' : '<span class="badge badge-danger">'.__('team.Inactive').'</span>';
                })

                ->rawColumns(['action','autoassign_edit','isadmin_edit','is_active'])
                ->make(true);
        }

        $categories = Category::all();
        $kementerian = \App\Models\LookupKementerian::where('is_active', 1)->orderBy('nama', 'ASC')->get();
        $kumpulanPengguna = \App\Models\LookupKumpulanPengguna::where('is_active', 1)->orderBy('nama', 'ASC')->get();

        return view('pages.team', compact('categories', 'kementerian', 'kumpulanPengguna'));
    }

    public function store(Request $request)
    {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required|string|email|unique:users',
//            'username' => 'required',
//        ]);

        if($request->signature == null)
        {
            $signature = '';
        }else{
            $signature = $request->signature;
        }

        $password = Str::random(8) . substr(str_shuffle('~!@#$%^&*()'), 0, 2);
        //Change Text Password to Hash - Start//
        $plaintext = $password;
        $majorsalt  = '';
        $len = strlen($plaintext);

        for ($i=0;$i<$len;$i++)
        {
            $majorsalt .= sha1(substr($plaintext,$i,1));
        }
        $passhash = sha1($majorsalt);
        //Change Text Password to Hash - End//



        if ($request->isadmin == 0) {

            // $categories = implode(',',$request->categories);
            $features = 'can_view_tickets,can_reply_tickets,can_resolve';

            User::create([
                'user' =>  $request->username,
                'pass' => $passhash,
                'isadmin' => $request->isadmin,
                'name' => $request->name,
                'email' => $request->email,
                'signature' => $signature,
                'categories' => '',
                'heskprivileges' => $features,
                'afterreply' => $request->afterreply,
                'autostart' => $request->autostart,
                'notify_customer_new' => $request->notify_customer_new,
                'notify_customer_reply' => $request->notify_customer_reply,
                'show_suggested' => $request->show_suggested,
                'notify_new_unassigned' => $request->notify_new_unassigned,
                'notify_new_my' => $request->notify_new_my,
                'notify_reply_unassigned' => $request->notify_reply_unassigned,
                'notify_reply_my' => $request->notify_reply_my,
                'notify_assigned' => $request->notify_assigned,
                'notify_pm' => $request->notify_pm,
                'notify_note' => $request->notify_note,
                'autoassign' => $request->autoassign ?? 0,
                'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                'kementerian_id' => $request->kementerian_id,
                'agensi_id' => $request->agensi_id,
                'sub_agensi_id' => $request->sub_agensi_id,
                'no_pejabat' => $request->no_pejabat,
                'no_hp' => $request->no_hp,
                'no_fax' => $request->no_fax,
                'alamat_pejabat' => $request->alamat_pejabat,
                'poskod' => $request->poskod,
                'negeri' => $request->negeri,
            ]);
        }else {


            User::create([
                'user' => $request->username,
                'pass' => $passhash,
                'isadmin' => $request->isadmin,
                'name' => $request->name,
                'email' => $request->email,
                'signature' => $signature,
                'heskprivileges' => '',
                'afterreply' => $request->afterreply,
                'autostart' => $request->autostart,
                'notify_customer_new' => $request->notify_customer_new,
                'notify_customer_reply' => $request->notify_customer_reply,
                'show_suggested' => $request->show_suggested,
                'notify_new_unassigned' => $request->notify_new_unassigned,
                'notify_new_my' => $request->notify_new_my,
                'notify_reply_unassigned' => $request->notify_reply_unassigned,
                'notify_reply_my' => $request->notify_reply_my,
                'notify_assigned' => $request->notify_assigned,
                'notify_pm' => $request->notify_pm,
                'notify_note' => $request->notify_note,
                'autoassign' => $request->autoassign ?? 0,
                'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                'kementerian_id' => $request->kementerian_id,
                'agensi_id' => $request->agensi_id,
                'sub_agensi_id' => $request->sub_agensi_id,
                'no_pejabat' => $request->no_pejabat,
                'no_hp' => $request->no_hp,
                'no_fax' => $request->no_fax,
                'alamat_pejabat' => $request->alamat_pejabat,
                'poskod' => $request->poskod,
                'negeri' => $request->negeri,
            ]);
        }
        Mail::to($request->email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new UserCreated($request->email,$password));

            flash('User Successfully Added', 'success');

        return redirect()->back();
    }

    public function profile($id)
    {
        $categories = Category::all();
        $user = User::find($id);
        $total_ticket = Ticket::where('owner', $user->id)->get()->count();
        $total_resolved = Ticket::where('owner', $user->id)->where('status','3')->get()->count();

        $kementerian = \App\Models\LookupKementerian::where('is_active', 1)->orderBy('nama', 'ASC')->get();
        $kumpulanPengguna = \App\Models\LookupKumpulanPengguna::where('is_active', 1)->orderBy('nama', 'ASC')->get();

        return view('pages.team_profile', compact('user','total_ticket','total_resolved','categories','kementerian','kumpulanPengguna'));
    }

    public function update_profile(Request $request)
    {
        $user = User::find($request->id);

        if ($request->email == $user->email)
        {
            if ($request->username == $user->user)
            {
                if ($request->isadmin == 0) {

                    $categories = '';
                    $features = 'can_view_tickets,can_reply_tickets,can_resolve';

                    User::updateOrCreate(
                        [
                            'id' => $request->id
                        ], [
                        'name' => $request->name,
                        'email' => $request->email,
                        'user' => $request->username,
                        'isadmin'   => $request->isadmin,
                        'categories' => $categories,
                        'heskprivileges' => $features,
                        'signature' => $request->signature,
                        'afterreply' => $request->afterreply,
                        'autostart' => $request->autostart,
                        'notify_customer_new' => $request->notify_customer_new,
                        'notify_customer_reply' => $request->notify_customer_reply,
                        'show_suggested' => $request->show_suggested,
                        'notify_new_unassigned' => $request->notify_new_unassigned,
                        'notify_new_my' => $request->notify_new_my,
                        'notify_reply_unassigned' => $request->notify_reply_unassigned,
                        'notify_reply_my' => $request->notify_reply_my,
                        'notify_assigned' => $request->notify_assigned,
                        'notify_pm' => $request->notify_pm,
                        'notify_note' => $request->notify_note,
                        'autoassign' => $request->autoassign ?? 0,
                        'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                        'kementerian_id' => $request->kementerian_id,
                        'agensi_id' => $request->agensi_id,
                        'sub_agensi_id' => $request->sub_agensi_id,
                        'no_pejabat' => $request->no_pejabat,
                        'no_hp' => $request->no_hp,
                        'no_fax' => $request->no_fax,
                        'alamat_pejabat' => $request->alamat_pejabat,
                        'poskod' => $request->poskod,
                        'negeri' => $request->negeri,

                    ]);

                }else{
                    User::updateOrCreate(
                        [
                            'id' => $request->id
                        ], [
                        'name' => $request->name,
                        'email' => $request->email,
                        'user' => $request->username,
                        'isadmin'   => $request->isadmin,
                        'categories' => '',
                        'heskprivileges' => '',
                        'signature' => $request->signature,
                        'afterreply' => $request->afterreply,
                        'autostart' => $request->autostart,
                        'notify_customer_new' => $request->notify_customer_new,
                        'notify_customer_reply' => $request->notify_customer_reply,
                        'show_suggested' => $request->show_suggested,
                        'notify_new_unassigned' => $request->notify_new_unassigned,
                        'notify_new_my' => $request->notify_new_my,
                        'notify_reply_unassigned' => $request->notify_reply_unassigned,
                        'notify_reply_my' => $request->notify_reply_my,
                        'notify_assigned' => $request->notify_assigned,
                        'notify_pm' => $request->notify_pm,
                        'notify_note' => $request->notify_note,
                        'autoassign' => $request->autoassign ?? 0,
                        'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                        'kementerian_id' => $request->kementerian_id,
                        'agensi_id' => $request->agensi_id,
                        'sub_agensi_id' => $request->sub_agensi_id,
                        'no_pejabat' => $request->no_pejabat,
                        'no_hp' => $request->no_hp,
                        'no_fax' => $request->no_fax,
                        'alamat_pejabat' => $request->alamat_pejabat,
                        'poskod' => $request->poskod,
                        'negeri' => $request->negeri,

                    ]);
                }


            }else{
                $duplicate_user = User::where('user', $request->username)->first();
                if ($duplicate_user != null){
                    return redirect()->back()->withErrors('Username not unique. Someone already register by using this username');
                }else{
                    if ($request->isadmin == 0) {

                        $categories = '';
                        $features = 'can_view_tickets,can_reply_tickets,can_resolve';

                        User::updateOrCreate(
                            [
                                'id' => $request->id
                            ], [
                            'name' => $request->name,
                            'email' => $request->email,
                            'user' => $request->username,
                            'isadmin'   => $request->isadmin,
                            'categories' => $categories,
                            'heskprivileges' => $features,
                            'signature' => $request->signature,
                            'afterreply' => $request->afterreply,
                            'autostart' => $request->autostart,
                            'notify_customer_new' => $request->notify_customer_new,
                            'notify_customer_reply' => $request->notify_customer_reply,
                            'show_suggested' => $request->show_suggested,
                            'notify_new_unassigned' => $request->notify_new_unassigned,
                            'notify_new_my' => $request->notify_new_my,
                            'notify_reply_unassigned' => $request->notify_reply_unassigned,
                            'notify_reply_my' => $request->notify_reply_my,
                            'notify_assigned' => $request->notify_assigned,
                            'notify_pm' => $request->notify_pm,
                            'notify_note' => $request->notify_note,
                            'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                            'kementerian_id' => $request->kementerian_id,
                            'agensi_id' => $request->agensi_id,
                            'sub_agensi_id' => $request->sub_agensi_id,
                            'no_pejabat' => $request->no_pejabat,
                            'no_hp' => $request->no_hp,
                            'no_fax' => $request->no_fax,
                            'alamat_pejabat' => $request->alamat_pejabat,
                            'poskod' => $request->poskod,
                            'negeri' => $request->negeri,
                        ]);

                    }else{
                        User::updateOrCreate(
                            [
                                'id' => $request->id
                            ], [
                            'name' => $request->name,
                            'email' => $request->email,
                            'user' => $request->username,
                            'isadmin'   => $request->isadmin,
                            'categories' => '',
                            'heskprivileges' => '',
                            'signature' => $request->signature,
                            'afterreply' => $request->afterreply,
                            'autostart' => $request->autostart,
                            'notify_customer_new' => $request->notify_customer_new,
                            'notify_customer_reply' => $request->notify_customer_reply,
                            'show_suggested' => $request->show_suggested,
                            'notify_new_unassigned' => $request->notify_new_unassigned,
                            'notify_new_my' => $request->notify_new_my,
                            'notify_reply_unassigned' => $request->notify_reply_unassigned,
                            'notify_reply_my' => $request->notify_reply_my,
                            'notify_assigned' => $request->notify_assigned,
                            'notify_pm' => $request->notify_pm,
                            'notify_note' => $request->notify_note,
                            'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                            'kementerian_id' => $request->kementerian_id,
                            'agensi_id' => $request->agensi_id,
                            'sub_agensi_id' => $request->sub_agensi_id,
                            'no_pejabat' => $request->no_pejabat,
                            'no_hp' => $request->no_hp,
                            'no_fax' => $request->no_fax,
                            'alamat_pejabat' => $request->alamat_pejabat,
                            'poskod' => $request->poskod,
                            'negeri' => $request->negeri,
                        ]);
                    }
                }
            }
        }
        else{
            $duplicate_email = User::where('email', $request->email)->first();
            if ($duplicate_email != null){
                return redirect()->back()->withErrors('Email not unique. Someone already register by using this email');
            }else{
                if ($request->username == $user->user)
                {
                    if ($request->isadmin == 0) {

                        $categories = '';
                        $features = 'can_view_tickets,can_reply_tickets,can_resolve';

                        User::updateOrCreate(
                            [
                                'id' => $request->id
                            ], [
                            'name' => $request->name,
                            'email' => $request->email,
                            'user' => $request->username,
                            'isadmin'   => $request->isadmin,
                            'categories' => $categories,
                            'heskprivileges' => $features,
                            'signature' => $request->signature,
                            'afterreply' => $request->afterreply,
                            'autostart' => $request->autostart,
                            'notify_customer_new' => $request->notify_customer_new,
                            'notify_customer_reply' => $request->notify_customer_reply,
                            'show_suggested' => $request->show_suggested,
                            'notify_new_unassigned' => $request->notify_new_unassigned,
                            'notify_new_my' => $request->notify_new_my,
                            'notify_reply_unassigned' => $request->notify_reply_unassigned,
                            'notify_reply_my' => $request->notify_reply_my,
                            'notify_assigned' => $request->notify_assigned,
                            'notify_pm' => $request->notify_pm,
                            'notify_note' => $request->notify_note,
                            'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                            'kementerian_id' => $request->kementerian_id,
                            'agensi_id' => $request->agensi_id,
                            'sub_agensi_id' => $request->sub_agensi_id,
                            'no_pejabat' => $request->no_pejabat,
                            'no_hp' => $request->no_hp,
                            'no_fax' => $request->no_fax,
                            'alamat_pejabat' => $request->alamat_pejabat,
                            'poskod' => $request->poskod,
                            'negeri' => $request->negeri,
                        ]);

                    }else{
                        User::updateOrCreate(
                            [
                                'id' => $request->id
                            ], [
                            'name' => $request->name,
                            'email' => $request->email,
                            'user' => $request->username,
                            'isadmin'   => $request->isadmin,
                            'categories' => '',
                            'heskprivileges' => '',
                            'signature' => $request->signature,
                            'afterreply' => $request->afterreply,
                            'autostart' => $request->autostart,
                            'notify_customer_new' => $request->notify_customer_new,
                            'notify_customer_reply' => $request->notify_customer_reply,
                            'show_suggested' => $request->show_suggested,
                            'notify_new_unassigned' => $request->notify_new_unassigned,
                            'notify_new_my' => $request->notify_new_my,
                            'notify_reply_unassigned' => $request->notify_reply_unassigned,
                            'notify_reply_my' => $request->notify_reply_my,
                            'notify_assigned' => $request->notify_assigned,
                            'notify_pm' => $request->notify_pm,
                            'notify_note' => $request->notify_note,
                            'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                            'kementerian_id' => $request->kementerian_id,
                            'agensi_id' => $request->agensi_id,
                            'sub_agensi_id' => $request->sub_agensi_id,
                            'no_pejabat' => $request->no_pejabat,
                            'no_hp' => $request->no_hp,
                            'no_fax' => $request->no_fax,
                            'alamat_pejabat' => $request->alamat_pejabat,
                            'poskod' => $request->poskod,
                            'negeri' => $request->negeri,
                        ]);
                    }

                }else{
                    $duplicate_user = User::where('user', $request->username)->first();
                    if ($duplicate_user != null){
                        return redirect()->back()->withErrors('Username not unique. Someone already register by using this username');
                    }else{
                        if ($request->isadmin == 0) {

                            $categories = '';
                            $features = 'can_view_tickets,can_reply_tickets,can_resolve';

                            User::updateOrCreate(
                                [
                                    'id' => $request->id
                                ], [
                                'name' => $request->name,
                                'email' => $request->email,
                                'user' => $request->username,
                                'isadmin'   => $request->isadmin,
                                'categories' => $categories,
                                'heskprivileges' => $features,
                                'signature' => $request->signature,
                                'afterreply' => $request->afterreply,
                                'autostart' => $request->autostart,
                                'notify_customer_new' => $request->notify_customer_new,
                                'notify_customer_reply' => $request->notify_customer_reply,
                                'show_suggested' => $request->show_suggested,
                                'notify_new_unassigned' => $request->notify_new_unassigned,
                                'notify_new_my' => $request->notify_new_my,
                                'notify_reply_unassigned' => $request->notify_reply_unassigned,
                                'notify_reply_my' => $request->notify_reply_my,
                                'notify_assigned' => $request->notify_assigned,
                                'notify_pm' => $request->notify_pm,
                                'notify_note' => $request->notify_note,
                                'autoassign' => $request->autoassign ?? 0,
                                'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                                'kementerian_id' => $request->kementerian_id,
                                'agensi_id' => $request->agensi_id,
                                'sub_agensi_id' => $request->sub_agensi_id,
                                'no_pejabat' => $request->no_pejabat,
                                'no_hp' => $request->no_hp,
                                'no_fax' => $request->no_fax,
                                'alamat_pejabat' => $request->alamat_pejabat,
                                'poskod' => $request->poskod,
                                'negeri' => $request->negeri,
                            ]);

                        }else{
                            User::updateOrCreate(
                                [
                                    'id' => $request->id
                                ], [
                                'name' => $request->name,
                                'email' => $request->email,
                                'user' => $request->username,
                                'isadmin'   => $request->isadmin,
                                'categories' => '',
                                'heskprivileges' => '',
                                'signature' => $request->signature,
                                'afterreply' => $request->afterreply,
                                'autostart' => $request->autostart,
                                'notify_customer_new' => $request->notify_customer_new,
                                'notify_customer_reply' => $request->notify_customer_reply,
                                'show_suggested' => $request->show_suggested,
                                'notify_new_unassigned' => $request->notify_new_unassigned,
                                'notify_new_my' => $request->notify_new_my,
                                'notify_reply_unassigned' => $request->notify_reply_unassigned,
                                'notify_reply_my' => $request->notify_reply_my,
                                'notify_assigned' => $request->notify_assigned,
                                'notify_pm' => $request->notify_pm,
                                'notify_note' => $request->notify_note,
                                'kumpulan_pengguna_id' => $request->kumpulan_pengguna_id,
                            ]);
                        }
                    }
                }
            }
        }
        flash('Profile Successfully Updated', 'success');
        return redirect()->back();
    }

    public function change_password_team(Request $request)
{
    if ($request->new_pass != $request->con_pass)
    {
        return redirect()->back()->withErrors('New Password and Confirm Password did not match');
    }
    else{

        $plaintext2 = $request->new_pass;
        $majorsalt2  = '';
        $len = strlen($plaintext2);

        for ($i=0;$i<$len;$i++)
        {
            $majorsalt2 .= sha1(substr($plaintext2,$i,1));
        }
        $corehash2 = sha1($majorsalt2);
        //Change Text Password to Hash - End//

        $user = User::find($request->id);
        $user->pass = $corehash2;
        $user->save();

        flash('Password Successfully Updated', 'success');
        return redirect()->back();
    }
}

    public function remove_team(Request $request){
        $user = User::find($request->id);

        Ticket::where('owner', $user->id)
            ->update(['owner' => 0]);

        ReplyDraft::where('owner', $user->id)
            ->delete();

        $user->delete();
        flash('User Successfully Deleted', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);

    }

    public function change_status(Request $request){
        $user = User::find($request->id);
        if($user->is_active == 1){
            $user->is_active = 0;
        }else{
            $user->is_active = 1;
        }
        $user->save();
        if($user->is_active == 1){
            flash('User Status Changed to Active', 'success');
        }else{
            flash('User Status Changed to Inactive', 'success');
        }
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    // API method to get Team Members by Kumpulan Pengguna ID
    public function getTeamByKumpulanPengguna($kumpulanPenggunaId)
    {
        $teamMembers = User::where('kumpulan_pengguna_id', $kumpulanPenggunaId)
                          ->where('is_active', 1)
                          ->orderBy('name', 'ASC')
                          ->get(['id', 'name']);
        
        return response()->json($teamMembers);
    }

}
