<?php

namespace App\Http\Controllers;


use App\Mail\Client\ForgotTracking;
use App\Mail\Staff\ClientClose;
use App\Mail\Staff\ClientReply;
use App\Mail\Staff\PublicSubmission as StaffNotificationSumbmission;
use App\Mail\Client\PublicSubmission as ClientNotificationSumbmission;
use App\Models\Attachment;
use App\Models\BanEmail;
use App\Models\Category;
use App\Models\KnowledgebaseArticle;
use App\Models\KnowledgebaseAttachment;
use App\Models\KnowledgebaseCategory;
use App\Models\Reply;
use App\Models\Slider;
use App\Models\ThankYouMessage;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use App\Models\CustomField;
use Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use function Symfony\Component\String\b;
use Illuminate\Support\Facades\Crypt;

class PublicController extends Controller
{
    public function index()
    {
        Session::forget('uid_otp');
        Session::forget('email_otp');
        Session::forget('email_otp_verified');

        $kb_article = KnowledgebaseArticle::whereIn('type',[0,1])->get();
        $sliders = Slider::where('file_name','!=',null)->get();
        return view('pages.public.main',compact('kb_article','sliders'));
    }

    public function setLanguage(Request $request)
    {
        $language = $request->input('language');
        
        if (in_array($language, ['en', 'ms'])) {
            Session::put('locale', $language);
            app()->setLocale($language);
            return response()->json(['success' => true, 'language' => $language]);
        }
        
        return response()->json(['success' => false], 400);
    }

    public function submission(Request $request)
    {
        $selected_category = $request->category;
        $selected_sub_category = $request->sub_category;

        $after_messages = CustomField::where('place', '1')->where('use', '1')->whereNotNull('value')->orderBy('order','ASC')->get();

        $before_messages = CustomField::where('place', '0')->where('use', '1')->whereNotNull('value')->orderBy('order','ASC')->get();

        $agensi = \App\Models\LookupAgensi::where('is_active', 1)->orderBy('nama', 'ASC')->get();
        $activePriorities = \App\Models\LookupPriority::where('is_active', 1)->orderBy('priority_value', 'ASC')->get();

        return view('pages.public.feedback_submission', compact('before_messages', 'after_messages','selected_category','selected_sub_category','agensi','activePriorities'));
    }
    public function submission_category(Request $request)
    {
        if(env('OTP_SERVICE') == 'enabled')
        {
            if($verrified = Session::get('email_otp_verified') == 1)
            {
                $public_categories = Category::where('type','0')->get();
                return view('pages.public.feedback_category', compact('public_categories'));
            }else{
                return redirect()->route('public.index');
            }

        }else{
            $public_categories = Category::where('type','0')->get();
            return view('pages.public.feedback_category', compact('public_categories'));
        }

    }
    public function submission_form(Request $request)
    {
        //Check Email Ban//
        $email_ban = BanEmail::where('email',$request->email)->get();
        if ($email_ban->count() != 0)
        {
            toastr()->warning('Your Email Has Been Banned', 'Failed');
            return redirect()->route('public.index');
        }
        //Check IP Ban//
        $ip_ban = checkBanIP($request->ip());
        if ($ip_ban != 0)
        {
            toastr()->warning('Your IP Has Been Banned', 'Failed');
            return redirect()->route('public.index');
        }



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

        $tracking_id = generateTicketID();
        $attachment_list= '';
        $owner = 0; // Always keep public tickets unassigned
        $owner_email = '';
        $history = '<li class="smaller">'.Carbon::now().' | submitted by Customer</li>';

        // Skip auto-assignment for public tickets - always keep them unassigned

        // Attachment Start //
        if($request->file()) {
            $this->validate($request, [
                'file.*' => 'mimes:gif,jpg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:2048',
            ]);
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
        // Attachment End //


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



        $data = $request->all();
        Ticket::create($data);

        // Skip staff notification since public tickets remain unassigned

        Mail::to($request->email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new ClientNotificationSumbmission($data));

        session(['submission_success' => $tracking_id]);

        flash('Ticket Successfully Submitted', 'success');

        return redirect()->route('public.submission.success');
    }
    public function submission_success(Request $request)
    {
        if(Session::get('submission_success') == null)
        {
            return redirect()->route('public.index');
        }else{
            $trackId = Session::get('submission_success');
            Session::forget('submission_success');
            $thank_you = ThankYouMessage::find(1);
            return view('pages.public.feedback_after_submission',compact('trackId','thank_you'));
        }
    }
    public function search_ticket()
    {
        return view('pages.public.feedback_search');
    }
    public function reply_ticket(Request $request)
    {

        if ($request->has('remember_email'))
        {
            if ($request->remember_email == 1)
            {
                session(['public_remember_email' => $request->email]);
            }
        }else{
            Session::forget('public_remember_email');
        }

        $ticket = Ticket::where('trackid', $request->trackid)->where('email', $request->email)->first();

        if ($ticket == null)
        {
            return redirect()->back()->withErrors('No ticket found for this tracking ID and email address.');
        }
        $replies = $ticket->replies()->get();
        //Update Replies To Read //
        Reply::where('replyto', $ticket->id)->where('read','0')->update(['read' => '1']);

        if ($ticket == null)
        {
            return redirect()->back()->withErrors(['Please Make Sure Your Email Address or Tracking ID are Correct']);
        }
        return view('pages.public.feedback_replay', compact('ticket','replies'));
    }
    public function reply_form(Request $request)
    {
        $attachment_list = '';

        if($request->file()) {
            // $this->validate($request, [
            //     'file.*' => 'mimes:gif,jpg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:2048',
            // ]);
            for ($x = 1; $x <= systemSetting()->attachments_max_size ; $x++) {
                {
                    if ($request->file[$x] != "undefined") {
                        $save_file_name = $request->tracking_id.'_'.$request->file[$x]->hashName();
                        $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
                        $file_size = $request->file[$x]->getSize();
                        $original_file_name = $request->file[$x]->getClientOriginalName();

                        $attachment = Attachment::create([
                            'ticket_id'     => $request->tracking_id,
                            'saved_name'    => $save_file_name,
                            'real_name'     => $original_file_name,
                            'size'          => $file_size,
                        ]);

                        $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                    }
                }
            }
        }

        $ticket = Ticket::where('trackid', $request->tracking_id)->first();
        if ($ticket->status != '0')
        {
            $ticket->status = '1';
        }

        $ticket->lastchange = Carbon::now();
        $ticket->replies += 1;
        $ticket->lastreplier = '0';
        $ticket->save();

        Reply::create([
            'replyto'    => $request->ticket_id,
            'name'       => $request->name,
            'message'    => $request->message,
            'dt'         => $request->dt,
            'attachments'=> $attachment_list,
        ]);



        $ticket = Ticket::find($request->ticket_id);

        $data = [
            'subject' => $ticket->subject,
            'trackid' => $ticket->trackid,
            'message' => $request->message,
        ];

        $owner = findUser($ticket->owner);
        if ($owner != null)
        {
            $owner_email = $owner->email;

            if($owner->notify_reply_my == 1){
                if (is_null($ticket->cc_email) || empty(json_decode($ticket->cc_email))) {
                    Mail::to($owner_email)
                        ->send(new ClientReply($data));
                } else {
                    $ccEmails = json_decode($ticket->cc_email, true);

                    Mail::to($owner_email)
                        ->cc($ccEmails)
                        ->send(new ClientReply($data));
                }
            }

        }else{
            $owner_email = User::where('isadmin','1')->first();
            if($owner_email->notify_reply_my == 1){
                if (is_null($ticket->cc_email) || empty(json_decode($ticket->cc_email))) {
                    Mail::to($owner_email->email)
                        ->send(new ClientReply($data));
                }else{
                    $ccEmails = json_decode($ticket->cc_email, true);

                    Mail::to($owner_email->email)
                        ->cc($ccEmails)
                        ->send(new ClientReply($data));
                }
            }
        }




        flash('Ticket Successfully Replied', 'Success');

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
    public function download($id)
    {
        $attachment = Attachment::where('att_id',Crypt::decryptString($id))->first();
        return Response::download(storage_path('app/public/attachment').'/'.$attachment->saved_name, $attachment->real_name);

    }
    public function close_ticket(Request $request)
    {
        $ticket = Ticket::where('trackid', $request->trackid)->first();
        $history = '<li class="smaller">'.Carbon::now().' | closed by Customer</li>';
        $ticket->status = '3';
        $ticket->closedat = Carbon::now();
        $ticket->closedby = '0';
        $ticket->history = $ticket->history.$history;
        $ticket->save();
        $data = Ticket::where('trackid', $ticket->trackid)->first();

        $owner = findUser($ticket->owner);
        if ($owner != null)
        {
            $owner_email = $owner->email;
        }else{
            $owner_email = User::where('isadmin','1')->first()->email;
        }

        $data = [
            'subject' => $ticket->subject,
            'trackid' => $ticket->trackid,
        ];

        Mail::to($owner_email)
//            ->cc($moreUsers)
//            ->bcc($evenMoreUsers)
            ->send(new ClientClose($data));

        flash('Ticket Successfully Closed', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
    public function forgot_tracking(Request $request)
    {
        if ($request->open == 1)
        {
            $tickets = Ticket::where('email', $request->email)->where('status','!=','3')->get();
        }else{
            $tickets = Ticket::where('email', $request->email)->get();

        }

        if ($tickets->count() == 0)
        {
            if ($request->open == 1) {
                return redirect()->back()->withErrors('No open tickets found for this email address.');
            }else{
                return redirect()->back()->withErrors('No tickets found for this email address.');
            }
        }

        Mail::to($request->email)
            ->send(new ForgotTracking($tickets));

        return redirect()->back();


    }
    public function knowledgebase_category()
    {
        $categories = KnowledgebaseCategory::where('type','0')->get();

        return view('pages.public.knowledgebase_category',compact('categories'));
    }
    public function knowledgebase(Request $request, $id)
    {
        if ($request->ajax()) {
            //Datatable
            $data = KnowledgebaseArticle::where('catid',$id)->get();
            return Datatables::of($data,)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {
                    $cat_name = kbCategoryName($data->catid);
                    return $cat_name;
                })
                ->addColumn('date', function ($data) {
                    return Carbon::parse($data->dt)->format('d-m-Y');
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn btn-icon btn-info mr-1" href="'.route('public.knowledgeabase.view',[$data->catid,$data->id]).'"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action','date','category'])
                ->make(true);
        }
        $category = KnowledgebaseCategory::find($id);
        return view('pages.public.knowledgebase', compact('id','category'));
    }
    public function knowledgebase_view($cat_id,$id)
    {
        $article = KnowledgebaseArticle::find($id);
        $article->views += 1;
        $article->save();
        return view('pages.public.knowledgebase_view', compact('article'));
    }
    public function knowledgebase_download($id)
    {
        $attachment = KnowledgebaseAttachment::where('att_id',Crypt::decryptString($id))->first();
        return Response::download(storage_path('app/public/attachment/knowledgebase').'/'.$attachment->saved_name, $attachment->real_name);

    }
}
