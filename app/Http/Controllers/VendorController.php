<?php

namespace App\Http\Controllers;

use App\Mail\Staff\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Datatable - only show vendors
            $data = User::where('user_type', 'vendor')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if($data->is_active == 1){
                        $btn = '<button class="btn btn-icon btn-info" data-id="'.$data->id.'" id="status"><i class="fa fa-pause"></i></button>';
                    }else{
                        $btn = '<button class="btn btn-icon btn-warning" data-id="'.$data->id.'" id="status"><i class="fa fa-play"></i></button>';
                    }
                    $btn = $btn.'&nbsp; <a href='.route('vendor.profile', $data->id).' class="btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';

                    return $btn;
                })
                ->addColumn('vendor_type_badge', function ($data) {
                    if ($data->vendor_type == 'admin') {
                        $type = '<span class="badge badge-primary mr-1 mb-1 mt-1">Admin</span>';
                    } else {
                        $type = '<span class="badge badge-info mr-1 mb-1 mt-1">Technical</span>';
                    }
                    return $type;
                })
                ->addColumn('is_active', function ($data) {
                    return $data->is_active == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->rawColumns(['action','vendor_type_badge','is_active'])
                ->make(true);
        }

        return view('pages.vendor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'company' => 'required',
            'phone_number' => 'required',
            'vendor_type' => 'required|in:admin,technical',
        ]);

        $password = Str::random(8) . substr(str_shuffle('~!@#$%^&*()'), 0, 2);

        // Hash password using legacy system method
        $plaintext = $password;
        $majorsalt = '';
        $len = strlen($plaintext);

        for ($i=0;$i<$len;$i++) {
            $majorsalt .= sha1(substr($plaintext,$i,1));
        }
        $passhash = sha1($majorsalt);

        // Create vendor user
        $user = User::create([
            'user' => $request->email, // Use email as username
            'pass' => $passhash,
            'isadmin' => '0', // Vendors are not admin
            'user_type' => 'vendor',
            'vendor_type' => $request->vendor_type,
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'no_hp' => $request->phone_number,
            'signature' => '',
            'categories' => '',
            'heskprivileges' => 'can_view_tickets,can_reply_tickets',
            'afterreply' => '0',
            'autostart' => '0',
            'notify_customer_new' => '0',
            'notify_customer_reply' => '0',
            'show_suggested' => '0',
            'notify_new_unassigned' => '1',
            'notify_new_my' => '1',
            'notify_reply_unassigned' => '0',
            'notify_reply_my' => '1',
            'notify_assigned' => '1',
            'notify_pm' => '0',
            'notify_note' => '0',
            'autoassign' => '0',
            'is_active' => 1,
        ]);

        // Send email with credentials
        try {
            Mail::to($request->email)->send(new UserCreated($request->email, $password));
        } catch (\Exception $e) {
            \Log::error('Failed to send vendor creation email: ' . $e->getMessage());
        }

        return redirect()->route('vendor.index')->with('success', 'Vendor created successfully. Login credentials have been sent to their email.');
    }

    public function profile($id)
    {
        $user = User::where('user_type', 'vendor')->findOrFail($id);
        return view('pages.vendor_profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('user_type', 'vendor')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|unique:users,email,'.$id,
            'company' => 'required',
            'phone_number' => 'required',
            'vendor_type' => 'required|in:admin,technical',
        ]);

        $user->update([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'user' => $request->email,
            'no_hp' => $request->phone_number,
            'vendor_type' => $request->vendor_type,
        ]);

        return redirect()->route('vendor.index')->with('success', 'Vendor updated successfully.');
    }

    public function updateStatus(Request $request)
    {
        $user = User::where('user_type', 'vendor')->findOrFail($request->id);
        $user->is_active = $user->is_active == 1 ? 0 : 1;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function destroy(Request $request)
    {
        $user = User::where('user_type', 'vendor')->findOrFail($request->id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Vendor deleted successfully']);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::where('user_type', 'vendor')->findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Hash password using legacy system method
        $plaintext = $request->password;
        $majorsalt = '';
        $len = strlen($plaintext);

        for ($i=0;$i<$len;$i++) {
            $majorsalt .= sha1(substr($plaintext,$i,1));
        }
        $passhash = sha1($majorsalt);

        $user->update(['pass' => $passhash]);

        return redirect()->route('vendor.profile', $id)->with('success', 'Password updated successfully.');
    }

    public function getVendorsByType($vendorType)
    {
        $vendors = User::where('user_type', 'vendor')
            ->where('vendor_type', $vendorType)
            ->where('is_active', 1)
            ->select('id', 'name', 'company', 'email')
            ->orderBy('name', 'ASC')
            ->get();

        return response()->json($vendors);
    }
}
