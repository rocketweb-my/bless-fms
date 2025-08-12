<?php

namespace App\Http\Controllers;

use App\Mail\Client\StaffReply;
use App\Mail\Staff\ClientClose;
use App\Mail\Staff\NewTicketAssign;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Note;
use App\Models\Reply;
use App\Models\ReplyDraft;
use App\Models\ReplyTemplate;
use App\Models\Ticket;
// use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class ReplyTicketController extends Controller
{

    public function index($track_id)
    {

        if (user()->isadmin != 1)
        {
            if(userPermissionChecker('can_view_tickets') == false)
            {
                return redirect()->route('ticket.index')->withErrors('You Do Not Have Permission To View Ticket');
            }
        }

        $ticket = Ticket::where('trackid', $track_id)->first();
        //Check Permission To View Ticket//
        if(User()->id != $ticket->owner && userPermissionChecker('can_view_ass_others') == false)
        {
            if (User()->isadmin == 0)
            {
                toastr()->error('You do not have permission to view this ticket', 'Error');
                return redirect()->route('ticket.index');
            }
        }

        $template_reply = ReplyTemplate::all();

        $replies = $ticket->replies()->get();
        $notes = $ticket->note()->get();
        if (user()->isadmin == 1 || userPermissionChecker('can_change_cat') == true)
        {
            $categories = Category::all();
        }elseif (user()->isadmin == 0 || userPermissionChecker('can_change_cat') == true){
            $categories = Category::whereIn('id', [user()->categories])->get();
        }else{
            $categories = null;
        }

        if (user()->isadmin == 1 || userPermissionChecker('can_assign_self') == true && userPermissionChecker('can_assign_others') == true)
        {
            $users = User::where('is_active', 1)->get();

        } else{
            if( userPermissionChecker('can_assign_self') == true && userPermissionChecker('can_assign_others') == false )
            {
                $users = User::where('id', user()->id)->get();
            }elseif( userPermissionChecker('can_assign_self') == false && userPermissionChecker('can_assign_others') == true )
            {
                $users = User::where('id','!=', user()->id)->where('is_active', 1)->get();
            }else{
                $users = null;
            }
        }

        $draft = ReplyDraft::where('owner', Session::get('user_id'))->where('ticket',$ticket->id)->orderBy('dt','DESC')->first();

        if ($draft == null)
        {
            $draft = new Collection();
            $draft->message = '';
        }
        return view('pages.ticket_reply', compact('ticket','replies','notes','draft','categories','users','template_reply'));
    }

    public function reply(Request $request)
    {

        $attachment_list = '';

        if($request->file()) {
            $this->validate($request, [
                'file.*' => 'mimes:gif,jpg,jpeg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:20480',
            ]);
            for ($x = 1; $x <= 6 ; $x++) {
                {
                    if (isset($request->file[$x]))
                    {
                        $save_file_name = $request->tracking_id.'_'.$request->file[$x]->hashName();
                        $path = $request->file[$x]->storeAs('public/attachment',$save_file_name);
                        $file_size = $request->file[$x]->getSize();
                        $original_file_name = $request->file[$x]->getClientOriginalName();

                        $attachment = Attachment::create([
                            'ticket'        => $request->tracking_id,
                            'saved_name'    => $save_file_name,
                            'real_name'     => $original_file_name,
                            'size'          => $file_size,
                        ]);

                        $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                    }
                }
            }
        }

        if ($request->has('signature') && $request->signature == 1)
        {
            $message = $request->message;
            if (user()->signature != null || user()->signature != "")
            {
                $message .= "<br /><br />" . user()->signature . "<br />";
            }
        }else{
            $message = $request->message;
        }

        //Insert Reply To Table Reply//
        Reply::create([
            'replyto'       => $request->ticket_id,
            'name'          => User()->name,
            'message'       => $message,
            'dt'            => Carbon::now(),
            'attachments'   => $attachment_list,
            'staffid'       => User()->id,
        ]);

        $new_status = '2';

        //Update Ticket Status to
        $ticket = Ticket::find($request->ticket_id);
        $ticket->status = $new_status;
        $ticket->lastreplier = '1';
        $ticket->replierid = User()->id;
        $ticket->replies += 1;
        $ticket->staffreplies += 1;


        //Working Time
       if  ($request->time_worked == '00:00:00') {
           $ticket->lastchange = Carbon::now();
       }else{

           $parts = explode(':', $ticket->time_worked);
           $seconds = ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

           $parts = explode(':', $request->time_worked);
           $seconds += ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];

           $ticket->time_worked = gmdate("H:i:s", $seconds);
           $ticket->lastchange = Carbon::now();
        }


        if ($ticket->firstreplyby == null)
        {
            $ticket->firstreply = Carbon::now();
            $ticket->firstreplyby = User()->id;
        }
        $ticket->save();

        $user = User::find(Session::get('user_id'));
        $user->replies += 1;
        $user->save();

        ReplyDraft::where('owner', Session::get('user_id'))->where('ticket',$request->ticket_id)->delete();


        if ($request->has('no_notify') && $request->no_notify == 1) {

        }else{
            if (is_null($ticket->cc_email) || empty(json_decode($ticket->cc_email))) {
                Mail::to($ticket->email)
                    ->send(new StaffReply($ticket, $request->message));

            } else {
                $ccEmails = json_decode($ticket->cc_email, true);

                Mail::to($ticket->email)
                    ->cc($ccEmails)
                    ->send(new StaffReply($ticket, $request->message));

            }
        }

        if(User()->afterreply == 0)
        {
            flash('Ticket Successfully Replied', 'success');
            return redirect()->back();
        }elseif (User()->afterreply == 1)
        {
            flash('Ticket Successfully Replied', 'success');
            return redirect()->route('ticket.index');
        }else{
            $ticket = Ticket::where('owner', User()->id)->select('trackid')->whereIn('status', ['0','1'])->first();

            if ($ticket == null)
            {
                flash('Ticket Successfully Replied', 'success');
                return redirect()->route('ticket.index');
            }else{
                flash('Ticket Successfully Replied', 'success');
                return redirect()->route('ticket.reply',$ticket->trackid);
            }
        }
    }

    public function save_to_draft(Request $request)
    {
        ReplyDraft::create([
            'owner' => Session::get('user_id'),
            'ticket'    => $request->ticket_id,
            'message'   => $request->message,
            'dt'        => Carbon::now(),
        ]);

        flash('Successfully Saved To Draft', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function note(Request $request)
    {



        $attachment_file = '';

        if($request->file()) {
            $this->validate($request, [
                'file' => 'mimes:gif,jpg,jpeg,png,zip,rar,csv,doc,docx,xls,xlsx,txt,pdf|max:20480',
            ]);
            if (isset($request->file))
            {
                $save_file_name = $request->tracking_id.'_'.$request->file->hashName();
                $path = $request->file->storeAs('public/attachment',$save_file_name);
                $file_size = $request->file->getSize();
                $original_file_name = $request->file->getClientOriginalName();
                $attachment_file = $save_file_name;
            }
        }

        Note::create([
            'ticket'        => $request->ticket_id,
            'who'           => Session::get('user_id'),
            'dt'            => Carbon::now(),
            'message'       => $request->message,
            'attachments'   => $attachment_file,
        ]);
        flash('Note Successfully Added', 'success');
        return redirect()->back();
    }

    public function edit_note(Request $request)
    {
        $note = Note::find($request->note_id);
        $note->message = $request->message;
        $note->save();
        flash('Note Successfully Edited', 'success');
        return redirect()->back();
    }

    public function delete_note(Request $request)
    {
        $note = Note::find($request->note_id);
        $note->delete();
        flash('Note Successfully Deleted', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function download_note_attachment($id)
    {

        $decrypt_id = Crypt::decryptString($id);
        $note = Note::find($decrypt_id);
        return Response::download(storage_path('app/public/attachment').'/'.$note->attachments);

    }

    public function change_category(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->category = $request->category;
        $ticket->save();

        flash('Successfully Move To New Category', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function change_status(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->status = $request->status;
        if ($request->status == 3)
        {
            $ticket->closedat = Carbon::now();
            $ticket->history .= '<li class="smaller">'.Carbon::now().' | Closed by '.user()->name.'</li>';

        }else{
            if ($request->status == 1) {
                $ticket->history .= '<li class="smaller">'.Carbon::now().' | Reopened by '.user()->name.'</li>';
            }else{
                $ticket->history .= '<li class="smaller">'.Carbon::now().' | Status Changed to '.$ticket->status_detail.' by '.user()->name.'</li>';
            }
            $ticket->closedat = null;
        }

        $ticket->save();

        flash('Successfully Change Status', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function change_priority(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->priority = $request->priority;
        $ticket->history .= '<li class="smaller">'.Carbon::now().' | Priority Changed to '.$ticket->priority_detail.' by '.user()->name.'</li>';
        $ticket->save();

        flash('Successfully Change Priority', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function change_owner(Request $request)
    {
        $new_user = User::find($request->user_id);
        $ticket = Ticket::find($request->id);
        $ticket->owner = $request->user_id;

        $ticket->history .= '<li class="smaller">'.Carbon::now().' | assigned to '.$new_user->name.' ('.$new_user->user.') by '.user()->name.'</li>';

        $ticket->save();


        if($new_user->notify_assigned == 1)
        {
            Mail::to($new_user->email)
            ->send(new NewTicketAssign($ticket));
        }

        flash('Successfully Assign To New Owner', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function delete_ticket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->delete();
        flash('Ticket Successfully Deleted', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function add_cc_email(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tickets,id',
            'cc_emails' => 'nullable|array',
            'cc_emails.*' => 'email',
        ]);

        $ticket = Ticket::findOrFail($request->id);

        // Get the submitted emails (add/remove)
        $updatedEmails = $request->cc_emails ?? [];

        // Save the updated email list to the ticket
        $ticket->cc_email = json_encode($updatedEmails);
        $ticket->save();

        flash('Successfully Added CC Email', 'success');
        return redirect()->back();
    }

    public function assign_ticket(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'assigned_user_id' => 'required|exists:users,id',
            'kumpulan_pengguna_id' => 'required|exists:lookup_kumpulan_pengguna,id',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);
        $assignedUser = User::findOrFail($request->assigned_user_id);

        // Update the ticket owner
        $ticket->owner = $request->assigned_user_id;
        
        // Add history entry
        $history = '<li class="smaller">'.Carbon::now().' | assigned to '.$assignedUser->name.' by '.User()->name.'</li>';
        $ticket->history = $ticket->history.$history;
        
        $ticket->save();

        // Send email notification to assigned user if they have notifications enabled
        if($assignedUser->notify_assign == 1) {
            $data = [
                'subject' => $ticket->subject,
                'trackid' => $ticket->trackid,
                'assigned_by' => User()->name,
            ];
            
            Mail::to($assignedUser->email)->send(new NewTicketAssign($data));
        }

        flash('Ticket successfully assigned to '.$assignedUser->name, 'success');
        return redirect()->back();
    }

    public function export_pdf(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $replies = Reply::where('replyto', $request->id)->get();

        $pdf = PDF::loadView('pdf.ticket_reply', compact('ticket','replies'));
        return $pdf->stream($ticket->trackid.'.pdf',array('Attachment'=>0));
    }

    public function export_with_notes_pdf(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $replies = Reply::where('replyto', $request->id)->get();
        $notes = Note::where('ticket', $request->id)->get();

        $pdf = PDF::loadView('pdf.ticket_reply_with_note', compact('ticket','replies','notes'));
        return $pdf->stream($ticket->trackid.'.pdf',array('Attachment'=>0));
    }



}
