<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\DraftTicket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\File;
use App\Models\Attachment;
use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Exports\TicketsExport;
use App\Models\TicketTemplate;
use App\Exports\TicketsExport2;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Mail\Client\ForgotTracking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\Staff\PublicSubmission as StaffNotificationSumbmission;
use App\Mail\Client\PublicSubmission as ClientNotificationSumbmission;
use Rap2hpoutre\FastExcel\FastExcel;


class TicketController extends Controller
{
    public function index(Request $request)
    {
        $current_user = User();
        $status_default = ['0','1','2','4','5'];
        $priority_default = \App\Models\LookupPriority::active()->pluck('priority_value')->map(function($value) {
            return (string) $value;
        })->toArray();
        $filter_onwer = [];

        // Check if user is vendor with technical type
        if ($current_user->user_type == 'vendor' && $current_user->vendor_type == 'technical')
        {
            // Technical vendor can only see tickets assigned to them
            $data = Ticket::select('trackid','lastchange','name','subject','status','lastreplier','replierid','owner','priority','dt','id','category')
                ->where('vendor_id', $current_user->id);

            if ( session('statusFilter') != null ) {
                $status = explode(',',Session::get('statusFilter'));
                $data = $data->whereIn('status', $status);
                $current_status_filtered = $status;
            }else{
                $data = $data->whereIn('status', $status_default);
                $current_status_filtered = $status_default;
            }

            if ( session('priorityFilter') != null ) {
                $priority= explode(',',Session::get('priorityFilter'));
                $data = $data->whereIn('priority', $priority);
                $current_priority_filtered = $priority;
            }else{
                $data = $data->whereIn('priority', $priority_default);
                $current_priority_filtered = $priority_default;
            }
        }
        // Check if user is vendor with admin type
        elseif ($current_user->user_type == 'vendor' && $current_user->vendor_type == 'admin')
        {
            // Vendor admin can only see tickets with categories "Aduan Aplikasi" and "Aduan Server"
            $vendorCategories = Category::whereIn('name', ['Aduan Aplikasi', 'Aduan Server'])->pluck('id')->toArray();

            $data = Ticket::select('trackid','lastchange','name','subject','status','lastreplier','replierid','owner','priority','dt','id','category')
                ->whereIn('category', $vendorCategories);

            if ( session('statusFilter') != null ) {
                $status = explode(',',Session::get('statusFilter'));
                $data = $data->whereIn('status', $status);
                $current_status_filtered = $status;
            }else{
                $data = $data->whereIn('status', $status_default);
                $current_status_filtered = $status_default;
            }

            if ( session('priorityFilter') != null ) {
                $priority= explode(',',Session::get('priorityFilter'));
                $data = $data->whereIn('priority', $priority);
                $current_priority_filtered = $priority;
            }else{
                $data = $data->whereIn('priority', $priority_default);
                $current_priority_filtered = $priority_default;
            }
        }
        elseif ($current_user->isadmin == 1)
        {
            if (session('showMyTicket') == null && session('showNoOwnerTicket') == null && session('showOtherTicket') == null)
            {
                Session::put('showMyTicket', 'true');
                Session::put('showOtherTicket', 'true');
                Session::put('showNoOwnerTicket', 'true');
            }

            $data = Ticket::select('trackid','lastchange','name','subject','status','lastreplier','replierid','owner','priority','dt','id','category');

            if ( session('statusFilter') != null ) {
                $status = explode(',',Session::get('statusFilter'));
                $data = $data->whereIn('status', $status);
                $current_status_filtered = $status;
            }else{
                $data = $data->whereIn('status', $status_default);
                $current_status_filtered = $status_default;
            }

            if ( session('priorityFilter') != null ) {
                $priority= explode(',',Session::get('priorityFilter'));
                $data = $data->whereIn('priority', $priority);
                $current_priority_filtered = $priority;

            }else{
                $data = $data->whereIn('priority', $priority_default);
                $current_priority_filtered = $priority_default;
            }

            if (session('showMyTicket') == 'true')
            {
                $show_my_ticket = [$current_user->id];
            }else{
                $show_my_ticket = [];

            }

            if (session('showNoOwnerTicket') == 'true')
            {
                $show_no_owner_ticket = [0];
            }else{
                $show_no_owner_ticket = [];
            }

            if (session('showOtherTicket') == 'true')
            {
                $show_other_ticket = Ticket::whereNotIn('owner',[0,$current_user->id])->distinct('owner')->pluck('owner')->toArray();
            }else{
                $show_other_ticket = [];
            }

            $filter_onwer = array_merge($show_my_ticket,$show_no_owner_ticket,$show_other_ticket);

            $data->whereIn('owner',$filter_onwer);

        }
        else{
            Session::put('showMyTicket', 'true');
            Session::put('showOtherTicket', 'false');
            Session::put('showNoOwnerTicket', 'false');

            if(userPermissionChecker('can_view_ass_others') == true)
            {
                $data = Ticket::select('trackid','lastchange','name','subject','status','lastreplier','replierid','owner','priority','dt','id','category');
            }else{
                $data = Ticket::select('trackid','lastchange','name','subject','status','lastreplier','replierid','owner','priority','dt','id','category')->where('owner', $current_user->id);
            }
            if ( session('statusFilter') != null ) {
                $status = explode(',',Session::get('statusFilter'));
                $data = $data->whereIn('status', $status);
                $current_status_filtered = $status;
            }else{
                $data = $data->whereIn('status', $status_default);
                $current_status_filtered = $status_default;

            }

            if ( session('priorityFilter') != null ) {
                $priority= explode(',',Session::get('priorityFilter'));
                $data = $data->whereIn('priority', $priority);
                $current_priority_filtered = $priority;

            }else{
                $data = $data->whereIn('priority', $priority_default);
                $current_priority_filtered = $priority_default;
            }

        }

        if ($request->client_name) {
            $data = $data->where('name', 'like', '%' . $request->client_name . '%');
        }

        if ($request->client_email) {
            $data = $data->where('email', $request->client_email);
        }

        if ($request->tracking_id) {
            $data = $data->where('trackid', 'like', '%' . $request->tracking_id . '%');
        }

        if ($request->category) {
            $data = $data->where('category', $request->category);
        }

        $data = $data->orderBy('lastchange', 'DESC')->get();

        if ($request->ajax())
        {
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('status_edit', function ($data) {
                    $statusLookup = \App\Models\LookupStatusLog::find($data->status);
                    if ($statusLookup) {
                        $status = '<span class="badge" style="background-color: ' . $statusLookup->color . '; color: white; margin-right: 4px; margin-bottom: 4px; margin-top: 4px;">' . $statusLookup->nama . '</span>';
                    } else {
                        // Fallback to New status (ID 0) color
                        $newStatusLookup = \App\Models\LookupStatusLog::find(0);
                        $color = $newStatusLookup ? $newStatusLookup->color : '#17a2b8';
                        $status = '<span class="badge" style="background-color: ' . $color . '; color: white; margin-right: 4px; margin-bottom: 4px; margin-top: 4px;">New</span>';
                    }
                    return $status;
                })

                // Priority Column
                ->addColumn('priority_edit', function ($data) {
                    $priorityName = getPriorityName($data->priority) ?: __("ticket.Unknown");
                    $badgeClass = match($data->priority) {
                        1 => 'badge-danger',
                        2 => 'badge-success', 
                        3 => 'badge-default',
                        default => 'badge-secondary'
                    };
                    return '<span class="badge ' . $badgeClass . ' mr-1 mb-1 mt-1">' . $priorityName . '</span>';
                })

//                ->addColumn('lastchange', function ($data) {
//                    return Carbon::parse($data->lastchange)->format('d-m-Y H:m:s');
//                })
                ->editColumn('lastchange', function ($data) {
                    return [
                        'display' => (new Carbon($data->lastchange))->format('d-m-Y H:m:s'),
                        'timestamp' => (new Carbon($data->lastchange))->timestamp
                    ];
                })
                ->addColumn('owner_edit', function ($data) {
                    if ($data->owner == 0)
                    {
                        return '';
                    }else
                    {
                        $owner = $data->owner_detail;
                        if ($owner == null)
                        {
                            return '';
                        }else
                        {
                            return $owner->name;
                        }
                    }
                })

                ->addColumn('lastreplier_edit', function ($data) {

                    if ($data->lastreplier == 0)
                    {
                        return $data->name;
                    } else
                    {
                        $replier = findUser($data->replierid);
                        if ($replier == null)
                        {
                            return '';
                        }else
                        {
                            return $replier->name;
                        }
                    }
                })

                ->addColumn('trackid_edit', function ($data) {
                    $link = '<a href="'.route('ticket.reply',$data->trackid).'">'.$data->trackid.'</a>';
                    return $link;
                })

                ->addColumn('subject_edit', function ($data) {

                    if ($data->owner != 0)
                    {
                        if ($data->owner == Session::get('user_id'))
                        {
                            $link = '<i class="fe fe-user"></i>&nbsp;<a href="'.route('ticket.reply',$data->trackid).'">'.$data->subject.'</a>';
                        }else
                        {
                            $link = '<i class="fe fe-user-plus"></i>&nbsp;<a href="'.route('ticket.reply',$data->trackid).'">'.$data->subject.'</a>';
                        }
                    }else
                    {
                        $link = '<a href="'.route('ticket.reply',$data->trackid).'">'.$data->subject.'</a>';
                    }
                    return $link;
                })

                ->addColumn('category_name', function ($data) {
                    $category = Category::find($data->category);
                    return $category ? $category->name : 'N/A';
                })

                ->addColumn('checkbox', function ($data) {

                    $checkbox = '<input type="checkbox" id="ticket_checkbox" name="ticket_checkbox" value="'. $data->id .'">';
                    return $checkbox;
                })


                ->rawColumns(['status_edit','checkbox','priority_edit','lastreplier_edit','trackid_edit','subject_edit'])
                ->make(true);
        }
        $total_ticket = $data->count();

        if (user()->isadmin == 1 || userPermissionChecker('can_assign_self') == true && userPermissionChecker('can_assign_others') == true)
        {
            $users = User::where('is_active', 1)->where('user_type', 'staff')->get();

        } else{
            if( userPermissionChecker('can_assign_self') == true && userPermissionChecker('can_assign_others') == false )
            {
                $users = User::where('id', user()->id)->where('user_type', 'staff')->get();
            }elseif( userPermissionChecker('can_assign_self') == false && userPermissionChecker('can_assign_others') == true )
            {
                $users = User::where('id','!=', user()->id)->where('is_active', 1)->where('user_type', 'staff')->get();
            }else{
                $users = null;
            }
        }

        return view('pages.tickets', compact('users','total_ticket','current_status_filtered','current_priority_filtered'));
    }

    public function store(Request $request)
    {
        //Admin Submit ticket not public//
        $tracking_id = generateTicketID();
        $history = '';
        $attachment_list = '';

        // Assign to Owner Start //
        $owner = 0;
        if (checkPermission('can_assign_others'))
        {
            $owner = $request->owner;

            // If ID is -1 the ticket will be unassigned
            if ($owner == -1)
            {

                $owner = 0;
            }
            // Automatically assign owner?
            elseif ($owner == -2 && systemSetting()->autoassign == 1)
            {

                $autoassign_owner = autoAssignTicket($request->category);

                if ($autoassign_owner != null)
                {
                    $owner   = $autoassign_owner->id;
                    $history .= '<li class="smaller">'.Carbon::now().' | automatically assigned to '.$autoassign_owner->name.' ('.$autoassign_owner->user.')</li>';
                }
                else
                {
                    $owner= 0;
                }
            }
            // Check for invalid owner values
            elseif ($owner < 1)
            {
                $owner = 0;
            }
            else
            {
                // Has the new owner access to the selected category?
                $res = User::select('name','isadmin','categories')->where('id',$owner)->first();
                if ($res != null)
                {
                    if ($res->isadmin == 0)
                    {
                        $categories = explode(',',$res->categories);
                        if (!in_array($request->category,$categories))
                        {
                            //If Owner tak boleh di assign pada cattegory yang di pilih, return back and show error message
                            toastr()->error('This owner doesn\'t have access to the selected category.', 'Error');
                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    //If Owner tak boleh di assign pada cattegory yang di pilih, return back and show error message
                    toastr()->error('This owner doesn\'t have access to the selected category.', 'Error');
                    return redirect()->back();
                }
            }
        }
        elseif (checkPermission('can_assign_self') && hesk_okCategory($tmpvar['category'],0) && !empty($_POST['assing_to_self']))
        {
            $owner = Session::get('user_id');
        }


        // Assign to Owner End//
        // Attachment Start //
        if($request->file()) {
            for ($x = 1; $x <= systemSetting()->attachments_max_size ; $x++) {
                {
                    if (isset($request->file[$x]))
                    {
                        $save_file_name = $tracking_id.'_'.$request->file[$x]->hashName();
                        $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
                        $file_size = $request->file[$x]->getSize();
                        $original_file_name = $request->file[$x]->getClientOriginalName();

                        $attachment = Attachment::create([
                            'ticket_id' => $tracking_id,
                            'saved_name' => $save_file_name,
                            'real_name' => $original_file_name,
                            'size'      => $file_size,
                        ]);


                        $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                    }
                }
            }
        }

        for ($x = 1; $x <= 50; $x++) {
            if ($request->has('custom'.$x))
            {
                if ($request['custom'.$x] == null)
                {
                    $request->request->add(['custom'.$x => '']);
                }
            }else{
                $request->request->add(['custom'.$x => '']);
            }
        }

        $request->request->add(['trackid' => $tracking_id]);
        $request->request->add(['owner' => $owner]);
        $request->request->add(['history' => $history]);
        $request->request->add(['attachments' => $attachment_list]);
        $request->request->add(['merged' => '']);
        $request->request->add(['language' => null]);
        $request->request->add(['articles' => null]);
        $request->request->add(['ip' => $request->ip()]);
        $request->request->add(['dt' => Carbon::now()]);
        $request->request->add(['lastchange' => Carbon::now()]);
        $request->request->add(['openedby' => $request->openby]);

        // Attachment End //
        //Create Ticket
//        Ticket::create([
//            'trackid'       => $tracking_id,
//            'name'          => $request->name,
//            'email'         => $request->email,
//            'category'      => $request->category,
//            'priority'      => $request->priority,
//            'subject'       => $request->subject,
//            'message'       => $request->message,
//            'dt'            => Carbon::now(),
//            'lastchange'    => Carbon::now(),
//            'articles'      => null,
//            'ip'            => $request->ip(),
//            'language'      => null,
//            'openedby'      => $request->openby,
//            'owner'         => $owner,
//            'attachments'   => $attachment_list,
//            'merged'        => '',
//            'history'       => $history,
//
//        ]);

        $data = $request->all();
        Ticket::create($data);

        //Insert attachment into table attachment
        flash('Ticket Successfully Created', 'success');
        return redirect()->route('ticket.index');


    }

    public function bulk_assign(Request $request)
    {
        foreach ($request->id as $id)
        {
            $ticket = Ticket::find($id);
            $ticket->owner = $request->selected;
            $ticket->assignedby = \User()->id;
            $ticket->save();
        }
        flash('Successfully Assign', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function bulk_priority_update(Request $request)
    {
        foreach ($request->id as $id)
        {
            $ticket = Ticket::find($id);
            $ticket->priority = $request->selected;
            $ticket->save();

        }
        flash('Successfully Change Priority', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function store_filter(Request $request)
    {

        Session::put('statusFilter', $request->status);
        Session::put('priorityFilter', $request->priority);
        Session::put('showMyTicket', $request->showMyTicket);
        Session::put('showOtherTicket', $request->showOtherTicket);
        Session::put('showNoOwnerTicket', $request->showNoOwnerTicket);

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function admin_create_ticket_category()
    {

        $categories = Category::all();
        return view('pages.admin_create_ticket_category',compact('categories'));

    }

    public function admin_create_ticket(Request $request)
    {
        // No longer requires category selection - form includes category selection
        $kaedah_melapor = \App\Models\LookupKaedahMelapor::where('is_active', 1)->orderBy('nama', 'ASC')->get();
        $agensi = \App\Models\LookupAgensi::where('is_active', 1)->orderBy('nama', 'ASC')->get();
        $activePriorities = \App\Models\LookupPriority::where('is_active', 1)->orderBy('priority_value', 'ASC')->get();

        // Get categories and sub-categories
        $categories = Category::all();
        $aduanAplikasiSubCategories = SubCategory::whereHas('category', function($q) {
            $q->where('name', 'Aduan Aplikasi');
        })->get();
        $aduanServerSubCategories = SubCategory::whereHas('category', function($q) {
            $q->where('name', 'Aduan Server');
        })->get();

        $before_messages = CustomField::where('place', '0')->whereIn('use', ['1','2'])->whereNotNull('value')->orderBy('order','ASC')->get();
        $after_messages = CustomField::where('place', '1')->whereIn('use', ['1','2'])->whereNotNull('value')->orderBy('order','ASC')->get();
        $ticket_templates = TicketTemplate::orderBy('tpl_order','ASC')->get();

        return view('pages.admin_create_ticket', compact('kaedah_melapor', 'agensi', 'activePriorities', 'categories', 'aduanAplikasiSubCategories', 'aduanServerSubCategories', 'before_messages', 'after_messages', 'ticket_templates'));
    }

    public function admin_create_ticket_store(Request $request)
    {
        // Route based on action type
        $action = $request->input('action', 'submit');

        if ($action === 'draft') {
            return $this->admin_save_draft($request);
        } elseif ($action === 'tutup') {
            return $this->admin_save_tutup($request);
        }

        // Default: Normal ticket submission
        // Validate required fields for admin ticket creation
        $validator = Validator::make($request->all(), [
            'kaedah_melapor_id' => 'required|exists:lookup_kaedah_melapor,id',
            'tarikh_aduan' => 'required|date',
            'masa_aduan' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'jantina' => 'required|in:Lelaki,Perempuan',
            'complaint_type' => 'required|in:general,technical,server',
            'subject' => 'required|string',
            'message' => 'required|string',
            'priority' => 'required',
        ], [
            'kaedah_melapor_id.required' => 'Kaedah Aduan is required.',
            'kaedah_melapor_id.exists' => 'Selected Kaedah Aduan is invalid.',
            'tarikh_aduan.required' => 'Tarikh Aduan is required.',
            'masa_aduan.required' => 'Masa Aduan is required.',
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be valid.',
            'phone_number.required' => 'Phone number is required.',
            'jantina.required' => 'Gender is required.',
            'complaint_type.required' => 'Complaint type is required.',
            'subject.required' => 'Subject is required.',
            'message.required' => 'Message is required.',
            'priority.required' => 'Priority is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin_create_ticket')
                ->withErrors($validator)
                ->withInput();
        }

        // Map complaint_type to category
        $categoryMapping = [
            'general' => 'Pertanyaan Umum',
            'technical' => 'Aduan Aplikasi',
            'server' => 'Aduan Server',
        ];

        // Find or create category based on complaint_type
        $categoryName = $categoryMapping[$request->complaint_type];
        $category = Category::firstOrCreate(['name' => $categoryName]);

        // Add category to request
        $request->merge(['category' => $category->id]);

        // Set sub_category based on complaint_type
        $subCategoryId = null;
        if ($request->complaint_type === 'technical' && $request->kategori_aplikasi) {
            $subCategoryId = $request->kategori_aplikasi;
        } elseif ($request->complaint_type === 'server' && $request->kategori_server) {
            $subCategoryId = $request->kategori_server;
        }
        $request->merge(['sub_category' => $subCategoryId]);

        // Set aduan_pertanyaan based on complaint_type
        $request->merge(['aduan_pertanyaan' => $request->complaint_type === 'general' ? 'pertanyaan' : 'aduan']);

        $tracking_id = generateTicketID();
        $history = '';
        $attachment_list = '';
        $owner_email = '';

        //Checkbox value format change from array to text//
        $checkboxs = CustomField::where('use','1')->where('type','checkbox')->whereNotNull('value')->get();

        if($checkboxs->count() > 0)
        {
            foreach ($checkboxs as $checkbox)
            {
                if ($request->has('custom'.$checkbox->id))
                {
                    $items = $request['custom'.$checkbox->id];
                    $total_array = count($items);
                    $new_custom = '';
                    foreach ( $items as $index => $item)
                    {
                        $new_custom .= $item;
                        if ($index < $total_array-1)
                        {
                            $new_custom .= '<br />';
                        }
                    }
                    $request->request->add(['custom'.$checkbox->id => $new_custom]);
                }
            }
        }


        $owner_email = '';

        // Assign to Owner Start //
        $owner = 0;
        if (checkPermission('can_assign_others'))
        {
            $owner = $request->owner;

            // If ID is -1 the ticket will be unassigned
            if ($owner == -1)
            {

                $owner = 0;
            }
            // Automatically assign owner?
            elseif ($owner == -2 && systemSetting()->autoassign == 1)
            {

                $autoassign_owner = autoAssignTicket($request->category);

                if ($autoassign_owner != null)
                {
                    $owner   = $autoassign_owner->id;
                    $history .= '<li class="smaller">'.Carbon::now().' | automatically assigned to '.$autoassign_owner->name.' ('.$autoassign_owner->user.')</li>';
                }
                else
                {
                    $owner= 0;
                }
            }
            // Check for invalid owner values
            elseif ($owner < 1)
            {
                $owner = 0;
            }
            else
            {
                // Has the new owner access to the selected category?
                $res = User::select('name','isadmin','categories')->where('id',$owner)->first();
                if ($res != null)
                {
                    if ($res->isadmin == 0)
                    {
                        $categories = explode(',',$res->categories);
                        if (!in_array($request->category,$categories))
                        {
                            //If Owner tak boleh di assign pada cattegory yang di pilih, return back and show error message
                            toastr()->error('This owner doesn\'t have access to the selected category.', 'Error');

                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    //If Owner tak boleh di assign pada cattegory yang di pilih, return back and show error message
                    toastr()->error('This owner doesn\'t have access to the selected category.', 'Error');

                    return redirect()->back();
                }
            }
        }
        elseif (checkPermission('can_assign_self') && hesk_okCategory($tmpvar['category'],0) && !empty($_POST['assing_to_self']))
        {
            $owner = Session::get('user_id');
        }



        // Attachment Start //
        if($request->file()) {
            $this->validate($request, [
                'file.*' => 'mimes:gif,jpg,jpeg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:20480', // 20MB = 20480KB
            ]);
            for ($x = 1; $x <= 6 ; $x++) { // Support up to 6 attachments
                {
                    if (isset($request->file[$x]))
                    {
                        $save_file_name = $tracking_id.'_'.$request->file[$x]->hashName();
                        $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
                        $file_size = $request->file[$x]->getSize();
                        $original_file_name = $request->file[$x]->getClientOriginalName();
                        $attachment = Attachment::create([
                            'ticket_id' => $tracking_id,
                            'saved_name' => $save_file_name,
                            'real_name' => $original_file_name,
                            'size'      => $file_size,
                        ]);
                        $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                    }
                }
            }
        }
        // Attachment End //




        for ($x = 1; $x <= 50; $x++) {
            if ($request->has('custom'.$x))
            {

            }else{
                $request->request->add(['custom'.$x => '']);
            }
        }

        $request->request->add(['trackid' => $tracking_id]);
        $request->request->add(['owner' => $owner]);
        $request->request->add(['history' => $history]);
        $request->request->add(['attachments' => $attachment_list]);
        $request->request->add(['merged' => '']);
        $request->request->add(['language' => null]);
        $request->request->add(['articles' => null]);
        $request->request->add(['ip' => $request->ip()]);
        $request->request->add(['status' => $request->input('status', 1)]); // Default to status 1 (New) if not set

        $data = $request->all();
        $ticket = Ticket::create($data);

        // Add created_at for email templates
        $data['created_at'] = now();

        if ($owner >= 1)
        {
            $user = User::find($owner);
            $owner_email = $user->email;
            if($user->notify_new_my == 1)
            {
                Mail::to($owner_email)
                ->send(new StaffNotificationSumbmission($data));
            }
        }else{
            $admin = User::where('isadmin',1)->first();
            if($admin->notify_new_my == 1)
            {
                Mail::to($admin->email)
                    ->send(new StaffNotificationSumbmission($data));
            }
        }

        if ($request->notify == 1)
        {
            Mail::to($request->email)
                ->send(new ClientNotificationSumbmission($data));
        }



        // If this was created from a draft, update the draft status to 'sent'
        if ($request->has('draft_id') && $request->draft_id) {
            $draft = DraftTicket::find($request->draft_id);
            if ($draft) {
                $draft->update(['status' => 'sent']);
            }
        }

        flash('Ticket Successfully Created', 'success');
        return redirect()->route('ticket.index');

    }

    public function export()
    {

        if (user()->isadmin == 1 || userPermissionChecker('can_change_cat') == true)
        {
            $categories = Category::all();
        }elseif (user()->isadmin == 0 || userPermissionChecker('can_change_cat') == true){
            $categories = Category::whereIn('id', [user()->categories])->get();
        }else{
            $categories = null;
        }

        return view('pages.ticket_export', compact('categories'));
    }

    public function export_ticket(Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to' => 'required',
            'categories' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ],[
            'categories.required' => __('ticket.Please Select Atleast One Category'),
            'status.required' => __('ticket.Please Select Atleast One Status'),
            'priority.required' => __('ticket.Please Select Atleast One Priority'),
        ]);


        $current_user = User();

        if ($current_user->isadmin == 1)
        {
            $tickets = Ticket::query()
                ->whereBetween('dt', [$request->date_from, $request->date_to])
                ->whereIn('category', $request->categories)
                ->whereIn('status', $request->status)
                ->whereIn('priority', $request->priority)
                ->get();
        }else{
            $tickets = Ticket::query()
                ->whereBetween('dt', [$request->date_from, $request->date_to])
                ->whereIn('category', $request->categories)
                ->whereIn('status', $request->status)
                ->whereIn('owner', $current_user->id)
                ->whereIn('priority', $request->priority)
                ->get();
        }
        $filename = 'tickets_' . date('Y-m-d_His') . '.xlsx';
        // Store in temporary location
        $tempPath = storage_path('app/public/temp/' . $filename);
        Excel::store(
            new TicketsExport($tickets),
            'public/temp/' . $filename
        );

        // Return download response and delete after send
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function export_ticket_2(Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to' => 'required',
            'categories' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ],[
            'categories.required' => __('ticket.Please Select Atleast One Category'),
            'status.required' => __('ticket.Please Select Atleast One Status'),
            'priority.required' => __('ticket.Please Select Atleast One Priority'),
        ]);

        return (new TicketsExport2(
            $request->date_from,
            $request->date_to,
            $request->categories,
            $request->status,
            $request->priority
        ))->download('tickets.xlsx');
    }

    public function export_ticket_pdf(Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to' => 'required',
            'categories' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ],[
            'categories.required' => __('ticket.Please Select Atleast One Category'),
            'status.required' => __('ticket.Please Select Atleast One Status'),
            'priority.required' => __('ticket.Please Select Atleast One Priority'),
        ]);


        $current_user = User();

        if ($current_user->isadmin == 1)
        {
            $tickets = Ticket::query()
                ->whereBetween('dt', [$request->date_from, $request->date_to])
                ->whereIn('category', $request->categories)
                ->whereIn('status', $request->status)
                ->whereIn('priority', $request->priority)
                ->get();
        }else{
            $tickets = Ticket::query()
                ->whereBetween('dt', [$request->date_from, $request->date_to])
                ->whereIn('category', $request->categories)
                ->whereIn('status', $request->status)
                ->whereIn('owner', $current_user->id)
                ->whereIn('priority', $request->priority)
                ->get();
        }
        $filename = 'tickets_' . date('Y-m-d_His');

        $pdf = PDF::loadView('export.tickets_pdf', compact('tickets'));
        return $pdf->stream($filename.'.pdf',array('Attachment'=>0));

    }

    public function export_ticket_excel(Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to' => 'required',
            'categories' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ],[
            'categories.required' => __('ticket.Please Select Atleast One Category'),
            'status.required' => __('ticket.Please Select Atleast One Status'),
            'priority.required' => __('ticket.Please Select Atleast One Priority'),
        ]);

        $current_user = User();

        if ($current_user->isadmin == 1)
        {
            $tickets = Ticket::query()
                ->whereBetween('dt', [$request->date_from, $request->date_to])
                ->whereIn('category', $request->categories)
                ->whereIn('status', $request->status)
                ->whereIn('priority', $request->priority)
                ->get();
        }else{
            $tickets = Ticket::query()
                ->whereBetween('dt', [$request->date_from, $request->date_to])
                ->whereIn('category', $request->categories)
                ->whereIn('status', $request->status)
                ->whereIn('owner', $current_user->id)
                ->whereIn('priority', $request->priority)
                ->get();
        }

        $filename = 'tickets_export_' . date('Y-m-d_His');
        $custom_fields = CustomField::where('use', '1')->get();


        return (new FastExcel($tickets))->download($filename.'.xlsx', function ($ticket) use ($custom_fields) {
            static $counter = 0;
            $data = [
                'No.' => ++$counter,
                'Tracking ID' => $ticket->trackid,
                'Date Created' => \Carbon\Carbon::parse($ticket->dt)->format('d-m-Y H:i:s'),
                'Date Updated' => \Carbon\Carbon::parse($ticket->lastchange)->format('d-m-Y H:i:s'),
                'Name' => $ticket->name,
                'Email' => $ticket->email,
                'Category' => $ticket->category_detail?->name ?? '-',
                'Priority' => $ticket->priority_detail ?? '-',
                'Status' => $ticket->status_detail ?? '-',
                'Subject' => $ticket->subject,
                'Message' => strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $ticket->message)),
                'Owner' => $ticket->owner_detail?->name ?? '-',
                'Time Worked' => $ticket->time_worked,
            ];

            // Add custom fields to the data array
            foreach ($custom_fields as $index => $custom_field) {
                $custom_field_name = json_decode($custom_field->name);
                $field_name = $custom_field_name->English ?? $custom_field_name;
                $field_value = $ticket['custom'.$index+1] ?? '-';
                $data[$field_name] = $field_value;
            }

            return $data;


        });
    }

    // Save ticket as draft
    public function admin_save_draft(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin_create_ticket')
                ->withErrors($validator)
                ->withInput();
        }

        // Check if updating existing draft or creating new
        $draftId = $request->input('draft_id');
        $draft = null;

        if ($draftId) {
            $draft = DraftTicket::find($draftId);
            // Verify ownership
            if (!$draft || $draft->created_by != Session::get('user_id')) {
                flash('Unauthorized access to draft', 'danger');
                return redirect()->route('admin_draft_tickets.index');
            }
            $draftTicketId = 'DRAFT_' . $draft->id;
        } else {
            $draftTicketId = 'DRAFT_' . uniqid();
        }

        // Process attachments - use draft ID for tracking
        $attachment_list = $draft ? $draft->attachments : '';
        if($request->file()) {
            $this->validate($request, [
                'file.*' => 'mimes:gif,jpg,jpeg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:20480',
            ]);

            for ($x = 1; $x <= 6 ; $x++) {
                if (isset($request->file[$x])) {
                    $save_file_name = $draftTicketId.'_'.$request->file[$x]->hashName();
                    $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
                    $file_size = $request->file[$x]->getSize();
                    $original_file_name = $request->file[$x]->getClientOriginalName();
                    $attachment = Attachment::create([
                        'ticket_id' => $draftTicketId,
                        'saved_name' => $save_file_name,
                        'real_name' => $original_file_name,
                        'size'      => $file_size,
                    ]);
                    $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                }
            }
        }

        // Process custom fields
        for ($x = 1; $x <= 50; $x++) {
            if (!$request->has('custom'.$x)) {
                $request->request->add(['custom'.$x => '']);
            }
        }

        $data = $request->except(['_token', 'action', 'draft_id']);
        $data['created_by'] = Session::get('user_id');
        $data['status'] = 'draft';
        $data['attachments'] = $attachment_list;
        // No trackid for draft - will be generated on submit

        if ($draft) {
            // Update existing draft
            $draft->update($data);
            flash('Draft ticket updated successfully', 'success');
        } else {
            // Create new draft
            DraftTicket::create($data);
            flash('Draft ticket saved successfully', 'success');
        }

        return redirect()->route('admin_draft_tickets.index');
    }

    // Save and auto-resolve ticket (Tutup) 
    public function admin_save_tutup(Request $request)
    {
        // Validate and process similar to normal store
        $validator = Validator::make($request->all(), [
            'kaedah_melapor_id' => 'required|exists:lookup_kaedah_melapor,id',
            'tarikh_aduan' => 'required|date',
            'masa_aduan' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'jantina' => 'required|in:Lelaki,Perempuan',
            'complaint_type' => 'required|in:general,technical,server',
            'subject' => 'required|string',
            'message' => 'required|string',
            'priority' => 'required',
        ], [
            'kaedah_melapor_id.required' => 'Kaedah Aduan is required.',
            'kaedah_melapor_id.exists' => 'Selected Kaedah Aduan is invalid.',
            'tarikh_aduan.required' => 'Tarikh Aduan is required.',
            'masa_aduan.required' => 'Masa Aduan is required.',
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be valid.',
            'phone_number.required' => 'Phone number is required.',
            'jantina.required' => 'Gender is required.',
            'complaint_type.required' => 'Complaint type is required.',
            'subject.required' => 'Subject is required.',
            'message.required' => 'Message is required.',
            'priority.required' => 'Priority is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin_create_ticket')
                ->withErrors($validator)
                ->withInput();
        }

        // Map complaint_type to category
        $categoryMapping = [
            'general' => 'Pertanyaan Umum',
            'technical' => 'Aduan Aplikasi',
            'server' => 'Aduan Server',
        ];

        $categoryName = $categoryMapping[$request->complaint_type];
        $category = Category::firstOrCreate(['name' => $categoryName]);
        $request->merge(['category' => $category->id]);

        // Set sub_category
        $subCategoryId = null;
        if ($request->complaint_type === 'technical' && $request->kategori_aplikasi) {
            $subCategoryId = $request->kategori_aplikasi;
        } elseif ($request->complaint_type === 'server' && $request->kategori_server) {
            $subCategoryId = $request->kategori_server;
        }
        $request->merge(['sub_category' => $subCategoryId]);
        $request->merge(['aduan_pertanyaan' => $request->complaint_type === 'general' ? 'pertanyaan' : 'aduan']);

        $tracking_id = generateTicketID();
        $history = '';
        $attachment_list = '';

        // Process attachments (same as store)
        if($request->file()) {
            $this->validate($request, [
                'file.*' => 'mimes:gif,jpg,jpeg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:20480',
            ]);
            for ($x = 1; $x <= 6 ; $x++) {
                if (isset($request->file[$x])) {
                    $save_file_name = $tracking_id.'_'.$request->file[$x]->hashName();
                    $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
                    $file_size = $request->file[$x]->getSize();
                    $original_file_name = $request->file[$x]->getClientOriginalName();
                    $attachment = Attachment::create([
                        'ticket_id' => $tracking_id,
                        'saved_name' => $save_file_name,
                        'real_name' => $original_file_name,
                        'size'      => $file_size,
                    ]);
                    $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                }
            }
        }

        // Process custom fields
        for ($x = 1; $x <= 50; $x++) {
            if (!$request->has('custom'.$x)) {
                $request->request->add(['custom'.$x => '']);
            }
        }

        $owner = $request->owner ?? 0;
        if ($owner == -1) {
            $owner = 0;
        }

        $request->request->add(['trackid' => $tracking_id]);
        $request->request->add(['owner' => $owner]);
        $request->request->add(['history' => $history]);
        $request->request->add(['attachments' => $attachment_list]);
        $request->request->add(['merged' => '']);
        $request->request->add(['language' => null]);
        $request->request->add(['articles' => null]);
        $request->request->add(['ip' => $request->ip()]);

        // Auto-resolve: Find "Resolved" status
        $resolvedStatus = \App\Models\LookupStatusLog::where('nama', 'Selesai')->orWhere('nama', 'Resolved')->first();
        $request->request->add(['status' => $resolvedStatus ? $resolvedStatus->id : 3]); // Default to 3 if not found

        $data = $request->all();
        Ticket::create($data);

        flash('Ticket closed and resolved successfully', 'success');
        return redirect()->route('ticket.index');
    }

    // View draft tickets list
    public function draft_tickets_index()
    {
        return view('pages.admin_draft_tickets');
    }

    // DataTables data for draft tickets
    public function draft_tickets_data()
    {
        $drafts = DraftTicket::where('created_by', Session::get('user_id'))
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($drafts)
            ->addColumn('category', function($draft) {
                return $draft->category_detail ? $draft->category_detail->name : '-';
            })
            ->addColumn('priority', function($draft) {
                return getPriorityName($draft->priority) ?: '-';
            })
            ->addColumn('status', function($draft) {
                $statusClass = $draft->status == 'draft' ? 'warning' : 'success';
                return '<span class="badge badge-'.$statusClass.'">'.ucfirst($draft->status).'</span>';
            })
            ->addColumn('action', function($draft) {
                $editBtn = '<a href="'.route('admin_draft_tickets.edit', $draft->id).'" class="btn btn-sm btn-info" title="Edit"><i class="fe fe-edit"></i></a>';
                $deleteBtn = '<button onclick="deleteDraft('.$draft->id.')" class="btn btn-sm btn-danger ml-1" title="Padam"><i class="fe fe-trash"></i></button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    // Edit draft - load draft data into create ticket form
    public function edit_draft($id)
    {
        $draft = DraftTicket::findOrFail($id);

        // Check if user owns this draft
        if ($draft->created_by != Session::get('user_id')) {
            abort(403, 'Unauthorized');
        }

        // Get necessary data for the form
        $kaedah_melapor = \App\Models\LookupKaedahMelapor::where('is_active', 1)->get();
        $agensi = \App\Models\LookupAgensi::where('is_active', 1)->get();
        $activePriorities = \App\Models\LookupPriority::active()->get();
        $categories = Category::all();

        $aduanAplikasiSubCategories = SubCategory::whereHas('category', function($q) {
            $q->where('name', 'Aduan Aplikasi');
        })->get();

        $aduanServerSubCategories = SubCategory::whereHas('category', function($q) {
            $q->where('name', 'Aduan Server');
        })->get();

        $before_messages = CustomField::where('place', '0')->whereIn('use', ['1','2'])->whereNotNull('value')->orderBy('order','ASC')->get();
        $after_messages = CustomField::where('place', '1')->whereIn('use', ['1','2'])->whereNotNull('value')->orderBy('order','ASC')->get();
        $ticket_templates = TicketTemplate::orderBy('tpl_order','ASC')->get();

        return view('pages.admin_create_ticket', compact(
            'kaedah_melapor', 'agensi', 'activePriorities', 'categories',
            'aduanAplikasiSubCategories', 'aduanServerSubCategories',
            'before_messages', 'after_messages', 'ticket_templates', 'draft'
        ));
    }

    // Delete draft
    public function delete_draft($id)
    {
        $draft = DraftTicket::findOrFail($id);

        // Check if user owns this draft
        if ($draft->created_by != Session::get('user_id')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $draft->delete();

        return response()->json(['message' => 'Draft deleted successfully']);
    }

    // Submit draft to ticket
    public function submit_draft_to_ticket($id)
    {
        \Log::info('Submit draft to ticket called', ['id' => $id]);

        $draft = DraftTicket::findOrFail($id);

        \Log::info('Draft found', ['draft' => $draft->toArray()]);

        // Check if user owns this draft
        if ($draft->created_by != Session::get('user_id')) {
            abort(403, 'Unauthorized');
        }

        // Generate tracking ID
        $tracking_id = generateTicketID();

        // Copy draft data to ticket
        $ticketData = $draft->toArray();
        unset($ticketData['id'], $ticketData['created_at'], $ticketData['updated_at'], $ticketData['created_by'], $ticketData['draft_id']);
        $ticketData['trackid'] = $tracking_id;
        $ticketData['status'] = 1; // New status
        $ticketData['dt'] = now();
        $ticketData['lastchange'] = now();

        // Update attachment ticket_id if exists
        if ($ticketData['attachments']) {
            $attachmentIds = explode(',', rtrim($ticketData['attachments'], ','));
            foreach ($attachmentIds as $attachmentStr) {
                if (!empty($attachmentStr)) {
                    $attachmentId = explode('#', $attachmentStr)[0];
                    Attachment::where('id', $attachmentId)->update(['ticket_id' => $tracking_id]);
                }
            }
        }

        // Create the ticket
        $ticket = Ticket::create($ticketData);

        // Refresh ticket to get timestamps and add to data for email templates
        $ticket->refresh();
        $ticketData['created_at'] = $ticket->created_at ?? now();
        $ticketData['updated_at'] = $ticket->updated_at ?? now();

        // Send email notifications
        $owner = $ticketData['owner'] ?? 0;

        // Send to assigned owner or admin
        if ($owner >= 1) {
            $user = User::find($owner);
            if ($user && $user->notify_new_my == 1) {
                Mail::to($user->email)->send(new StaffNotificationSumbmission($ticketData));
            }
        } else {
            $admin = User::where('isadmin', 1)->first();
            if ($admin && $admin->notify_new_my == 1) {
                Mail::to($admin->email)->send(new StaffNotificationSumbmission($ticketData));
            }
        }

        // Send to customer if notify is enabled
        if (isset($ticketData['notify']) && $ticketData['notify'] == 1) {
            Mail::to($ticketData['email'])->send(new ClientNotificationSumbmission($ticketData));
        }

        // Update draft status to 'sent' so it won't show in draft list
        $draft->update(['status' => 'sent']);

        \Log::info('Draft status updated to sent', ['draft_id' => $id]);

        flash('Draft ticket submitted successfully with ID: ' . $tracking_id, 'success');
        return redirect()->route('ticket.index');
    }
}
