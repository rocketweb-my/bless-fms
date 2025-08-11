<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Charts\MonthlyUsersChart;
class DashboardController extends Controller
{
    public function index(Request $request, MonthlyUsersChart $chart){

//        $test = Ticket::whereDate('dt', '<', Carbon::now()->subDays(3))->get();
//
//        dump(Carbon::now());
//        dump(Carbon::now()->subDays(3));
//        dd($test);




        $status_default = ['0','1','2','4','5'];
        $user = User();

        $total_ticket = Ticket::where('owner', $user->id)->get()->count();
        $new_ticket = Ticket::where('owner', $user->id)->where('status', '0')->get()->count();
        $waiting_reply_ticket = Ticket::where('owner', $user->id)->where('status', '1')->get()->count();
        $replied_ticket = Ticket::where('owner', $user->id)->where('status', '2')->get()->count();
        $resolved_ticket = Ticket::where('owner', $user->id)->where('status', '3')->get()->count();
        $in_progress_ticket = Ticket::where('owner', $user->id)->where('status', '4')->get()->count();
        $on_hold_ticket = Ticket::where('owner', $user->id)->where('status', '5')->get()->count();

        // Use priority-specific overdue calculation
        $baseQuery = Ticket::where('owner', $user->id)->whereIn('status', $status_default);
        $over_due_ticket = getOverdueTicketsQuery($baseQuery)->count();
        $chart = $chart->build();

        // dd($chart);


        if ($over_due_ticket != 0) {
            // Get overdue tickets using priority-specific logic
            $baseDataQuery = Ticket::select('trackid', 'lastchange', 'name', 'subject', 'status', 'lastreplier', 'replierid', 'owner', 'priority', 'dt', 'id')
                ->whereIn('status', $status_default)
                ->where('owner', $user->id);
            $data = getOverdueTicketsQuery($baseDataQuery)->orderBy('lastchange', 'DESC')->get();

            if ($request->ajax()) {
                //Datatable
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
                    ->addColumn('priority_edit', function ($data) {
                        $priorityName = getPriorityName($data->priority) ?: __('main.Unknown');
                        $badgeClass = match($data->priority) {
                            1 => 'badge-danger',
                            2 => 'badge-success',
                            3 => 'badge-default',
                            default => 'badge-secondary'
                        };
                        return '<span class="badge ' . $badgeClass . ' mr-1 mb-1 mt-1">' . $priorityName . '</span>';
                    })
                    ->editColumn('lastchange', function ($data) {
                        return [
                            'display' => (new Carbon($data->lastchange))->format('d-m-Y H:m:s'),
                            'timestamp' => (new Carbon($data->lastchange))->timestamp
                        ];
                    })
                    ->addColumn('lastreplier_edit', function ($data) {

                        if ($data->lastreplier == '0') {
                            return $data->name;
                        } else {
                            $replier = findUser($data->replierid);
                            if ($replier == null) {
                                return '';
                            } else {
                                return $replier->name;
                            }
                        }
                        return $priority;
                    })
                    ->addColumn('trackid_edit', function ($data) {
                        $link = '<a href="' . route('ticket.reply', $data->trackid) . '">' . $data->trackid . '</a>';
                        return $link;
                    })
                    ->addColumn('subject_edit', function ($data) {

                        if ($data->owner != 0) {
                            if ($data->owner == Session::get('user_id')) {
                                $link = '<i class="fe fe-user"></i>&nbsp;<a href="' . route('ticket.reply', $data->trackid) . '">' . $data->subject . '</a>';
                            } else {
                                $link = '<i class="fe fe-user-plus"></i>&nbsp;<a href="' . route('ticket.reply', $data->trackid) . '">' . $data->subject . '</a>';
                            }
                        } else {
                            $link = '<a href="' . route('ticket.reply', $data->trackid) . '">' . $data->subject . '</a>';
                        }
                        return $link;
                    })
                    ->addColumn('checkbox', function ($data) {

                        $checkbox = '<input type="checkbox" id="ticket_checkbox" name="ticket_checkbox" value="' . $data->id . '">';
                        return $checkbox;
                    })
                    ->rawColumns(['status_edit', 'checkbox', 'priority_edit', 'lastreplier_edit', 'trackid_edit', 'subject_edit'])
                    ->make(true);
            }
        }

        return view('pages.dashboard',compact('total_ticket','new_ticket','waiting_reply_ticket','replied_ticket','resolved_ticket','in_progress_ticket','on_hold_ticket','over_due_ticket', 'chart'));
    }
}
