<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomField;
use App\Models\ReplyTemplate;
use App\Models\TicketTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TemplateController extends Controller
{
    public function ticket(Request $request)
    {
        if (user()->isadmin != 1 ||userPermissionChecker('can_man_ticket_tpl') == false)
        {
            return redirect()->route('dashboard.index')->withErrors('You Do Not Have Permission To Manage Ticket Template');
        }

        if ($request->ajax()) {
            //Datatable
            $data = TicketTemplate::orderBy('tpl_order', 'ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<button class="btn btn-icon btn-success" data-id="'.$data->id.'"  data-title="'.$data->title.'" data-message="'.$data->message.'" data-toggle="modal" data-target="#editTicketTemplate" id="edit"><i class="fa fa-pencil-square-o"></i></button>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.template_ticket');
    }

    public function store_ticket(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required',
            'message'        => 'required',
        ]);

        $tpl_order = 10;
        $template_order = TicketTemplate::orderBy('tpl_order', 'DESC')->first();
        if ($template_order)
        {
            $tpl_order = $template_order->tpl_order + 10;
        }

        TicketTemplate::create([
            'title'     => $request->title,
            'message'   => $request->message,
            'tpl_order' => $tpl_order,
        ]);

        flash('Ticket Template Successfully Added', 'success');
        return redirect()->back();
    }

    public function edit_ticket(Request $request)
    {
        $template = TicketTemplate::find($request->id);
        $template->title = $request->title;
        $template->message = $request->message;
        $template->save();

        flash('Ticket Template Successfully Edited', 'success');
        return redirect()->back();
    }

    public function delete_ticket(Request $request)
    {
        $template = TicketTemplate::find($request->id);
        $template->delete();

        flash('Ticket Template Successfully Deleted', 'success');
        return redirect()->back();
    }

    public function canned(Request $request)
    {
        if (user()->isadmin != 1 ||userPermissionChecker('can_man_canned') == false)
        {
            return redirect()->route('dashboard.index')->withErrors('You Do Not Have Permission To Manage Canned Template');
        }

        $custom_fields = CustomField::where('order', '!=' ,'1000')->orderBy('order','ASC')->get();

        if ($request->ajax()) {
            //Datatable
            $data = ReplyTemplate::orderBy('reply_order', 'ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<button class="btn btn-icon btn-success" data-id="'.$data->id.'"  data-title="'.$data->title.'" data-message="'.$data->message.'" data-toggle="modal" data-target="#editCanned" id="edit"><i class="fa fa-pencil-square-o"></i></button>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.template_reply', compact('custom_fields'));
    }

    public function store_canned(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required',
            'message'        => 'required',
        ]);

        $reply_order = 10;
        $template_order = ReplyTemplate::orderBy('reply_order', 'DESC')->first();
        if ($template_order)
        {
            $reply_order = $template_order->reply_order + 10;
        }

        ReplyTemplate::create([
            'title'         => $request->title,
            'message'       => $request->message,
            'reply_order'   => $reply_order,
        ]);

        flash('Canned Response Template Successfully Added', 'success');
        return redirect()->back();
    }

    public function edit_canned(Request $request)
    {
        $template = ReplyTemplate::find($request->id);
        $template->title = $request->title;
        $template->message = $request->message;
        $template->save();

        flash('Canned Response Template Successfully Edited', 'success');
        return redirect()->back();
    }

    public function delete_canned(Request $request)
    {
        $template = ReplyTemplate::find($request->id);
        $template->delete();

        flash('Canned Response Template Successfully Deleted', 'success');
        return redirect()->back();
    }
}
