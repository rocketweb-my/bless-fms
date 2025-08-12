<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Models\CustomField;
use Yajra\DataTables\Facades\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportV2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('user.session');
    }

    public function index()
    {
        return view('pages.admin.reportv2.index');
    }

    public function generate()
    {
        $categories = Category::where('type', '0')->get();
        $users = User::where('isadmin', 1)->get();
        $customFields = CustomField::getFilterableFields();
        
        return view('pages.admin.reportv2.generate', compact('categories', 'users', 'customFields'));
    }

    public function getTicketDetails($trackid)
    {
        $ticket = Ticket::where('trackid', $trackid)->first();

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        // Get replies using the relationship method explicitly
        $replies = $ticket->replies()->orderBy('dt', 'asc')->get();

        // Get custom fields with values
        $customFields = CustomField::whereIn('use', ['1', '2'])
            ->whereNotNull('value')
            ->orderBy('order')
            ->get()
            ->map(function($field) use ($ticket) {
                $value = $ticket->{'custom' . $field->id} ?? '';
                
                // Format checkbox values (remove <br /> tags)
                if ($field->type === 'checkbox' && $value) {
                    $value = str_replace(['<br />', '<br/>', '<br>'], ', ', $value);
                }
                
                return [
                    'id' => $field->id,
                    'name' => $field->localized_name,
                    'type' => $field->type,
                    'value' => $value ?: '-'
                ];
            })
            ->filter(function($field) {
                return $field['value'] !== '-' && $field['value'] !== '';
            });

        // Get ticket details with relationships
        $ticketData = [
            'trackid' => $ticket->trackid,
            'subject' => $ticket->subject,
            'name' => $ticket->name,
            'email' => $ticket->email,
            'message' => $ticket->message,
            'dt' => \Carbon\Carbon::parse($ticket->dt)->format('d/m/Y H:i:s'),
            'lastchange' => \Carbon\Carbon::parse($ticket->lastchange)->format('d/m/Y H:i:s'),
            'status' => $this->getStatusText($ticket->status),
            'priority' => $this->getPriorityText($ticket->priority),
            'category' => categoryName($ticket->category)->name ?? '-',
            'owner' => findUser($ticket->owner)?->name ?? 'Unassigned',
            'time_worked' => $ticket->time_worked ?? '0',
            'replies_count' => $replies->count(),
            'custom_fields' => $customFields,
            'replies' => $replies->map(function($reply) {
                return [
                    'name' => $reply->name,
                    'message' => $reply->message,
                    'dt' => \Carbon\Carbon::parse($reply->dt)->format('d/m/Y H:i:s'),
                ];
            })
        ];

        return response()->json($ticketData);
    }

    public function preview(Request $request)
    {
        $query = Ticket::query();
        
        // Apply filters
        if ($request->filled('categories') && !in_array('all', $request->categories)) {
            $query->whereIn('category', $request->categories);
        }
        
        if ($request->filled('sub_categories') && !in_array('all', $request->sub_categories)) {
            $query->whereIn('sub_category', $request->sub_categories);
        }
        
        if ($request->filled('date_from')) {
            $query->where('dt', '>=', $request->date_from . ' 00:00:00');
        }
        
        if ($request->filled('date_to')) {
            $query->where('dt', '<=', $request->date_to . ' 23:59:59');
        }
        
        if ($request->filled('status') && !in_array('all', $request->status)) {
            $query->whereIn('status', $request->status);
        }
        
        if ($request->filled('priority') && !in_array('all', $request->priority)) {
            $query->whereIn('priority', $request->priority);
        }

        // Apply new filter fields
        if ($request->filled('aduan_pertanyaan') && !in_array('all', $request->aduan_pertanyaan)) {
            $query->whereIn('aduan_pertanyaan', $request->aduan_pertanyaan);
        }
        
        if ($request->filled('kaedah_melapor') && !in_array('all', $request->kaedah_melapor)) {
            $query->whereIn('kaedah_melapor_id', $request->kaedah_melapor);
        }
        
        if ($request->filled('agensi') && !in_array('all', $request->agensi)) {
            $query->whereIn('agensi_id', $request->agensi);
        }
        
        if ($request->filled('lesen') && !in_array('all', $request->lesen)) {
            $query->whereIn('lesen_id', $request->lesen);
        }
        
        if ($request->filled('bl_no')) {
            $query->where('bl_no', 'like', '%' . $request->bl_no . '%');
        }

        // Apply custom field filters
        $this->applyCustomFieldFilters($query, $request);

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('trackid', function ($ticket) {
                    return '<a href="#" class="ticket-detail-link" data-trackid="' . $ticket->trackid . '">' . $ticket->trackid . '</a>';
                })
                ->addColumn('subject', function ($ticket) {
                    return $ticket->subject;
                })
                ->addColumn('message', function ($ticket) {
                    return \Str::limit(strip_tags($ticket->message), 100);
                })
                ->addColumn('dt', function ($ticket) {
                    return \Carbon\Carbon::parse($ticket->dt)->format('d/m/Y H:i:s');
                })
                ->addColumn('first_response_date', function ($ticket) {
                    $firstReply = $ticket->replies()->where('name', '!=', $ticket->name)->first();
                    return $firstReply ? \Carbon\Carbon::parse($firstReply->dt)->format('d/m/Y H:i:s') : '-';
                })
                ->addColumn('category_name', function ($ticket) {
                    return categoryName($ticket->category)->name ?? '-';
                })
                ->addColumn('status_text', function ($ticket) {
                    $statusLookup = \App\Models\LookupStatusLog::find($ticket->status);
                    if ($statusLookup) {
                        return '<span class="badge" style="background-color: ' . $statusLookup->color . '; color: white; margin-right: 4px; margin-bottom: 4px; margin-top: 4px;">' . $statusLookup->nama . '</span>';
                    } else {
                        // Fallback to New status (ID 0) color
                        $newStatusLookup = \App\Models\LookupStatusLog::find(0);
                        $color = $newStatusLookup ? $newStatusLookup->color : '#17a2b8';
                        return '<span class="badge" style="background-color: ' . $color . '; color: white; margin-right: 4px; margin-bottom: 4px; margin-top: 4px;">New</span>';
                    }
                })
                ->addColumn('priority_text', function ($ticket) {
                    $priorityName = getPriorityName($ticket->priority) ?: __("advance_report.Unknown");
                    $badgeClass = match((string)$ticket->priority) {
                        '1' => 'badge-danger',
                        '2' => 'badge-success', 
                        '3' => 'badge-default',
                        default => 'badge-secondary'
                    };
                    return '<span class="badge ' . $badgeClass . ' mr-1 mb-1 mt-1">' . $priorityName . '</span>';
                })
                ->rawColumns(['trackid', 'subject', 'status_text', 'priority_text'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function export(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date',
        ]);

        $query = Ticket::query();
        
        // Apply filters
        if ($request->filled('categories') && !in_array('all', $request->categories)) {
            $query->whereIn('category', $request->categories);
        }
        
        if ($request->filled('sub_categories') && !in_array('all', $request->sub_categories)) {
            $query->whereIn('sub_category', $request->sub_categories);
        }
        
        if ($request->filled('date_from')) {
            $query->where('dt', '>=', $request->date_from . ' 00:00:00');
        }
        
        if ($request->filled('date_to')) {
            $query->where('dt', '<=', $request->date_to . ' 23:59:59');
        }
        
        if ($request->filled('status') && !in_array('all', $request->status)) {
            $query->whereIn('status', $request->status);
        }
        
        if ($request->filled('priority') && !in_array('all', $request->priority)) {
            $query->whereIn('priority', $request->priority);
        }

        // Apply new filter fields
        if ($request->filled('aduan_pertanyaan') && !in_array('all', $request->aduan_pertanyaan)) {
            $query->whereIn('aduan_pertanyaan', $request->aduan_pertanyaan);
        }
        
        if ($request->filled('kaedah_melapor') && !in_array('all', $request->kaedah_melapor)) {
            $query->whereIn('kaedah_melapor_id', $request->kaedah_melapor);
        }
        
        if ($request->filled('agensi') && !in_array('all', $request->agensi)) {
            $query->whereIn('agensi_id', $request->agensi);
        }
        
        if ($request->filled('lesen') && !in_array('all', $request->lesen)) {
            $query->whereIn('lesen_id', $request->lesen);
        }
        
        if ($request->filled('bl_no')) {
            $query->where('bl_no', 'like', '%' . $request->bl_no . '%');
        }

        // Apply custom field filters
        $this->applyCustomFieldFilters($query, $request);

        // Get the filtered tickets
        $tickets = $query->get();


        $filename = 'advanced_report_' . date('Y-m-d_His');
        
        return (new FastExcel($tickets))->download($filename.'.xlsx', function ($ticket) {
            static $counter = 0;
            
            // Get first response date safely
            try {
                $firstReply = $ticket->replies()->where('name', '!=', $ticket->name)->first();
                $firstResponseDate = $firstReply ? 
                    \Carbon\Carbon::parse($firstReply->dt)->format('d/m/Y H:i:s') : 
                    '-';
            } catch (\Exception $e) {
                $firstResponseDate = '-';
            }

            // Get category name safely
            try {
                $categoryName = categoryName($ticket->category)->name ?? '-';
            } catch (\Exception $e) {
                $categoryName = '-';
            }

            // Get owner name safely
            try {
                $ownerName = findUser($ticket->owner)?->name ?? '-';
            } catch (\Exception $e) {
                $ownerName = '-';
            }

            return [
                'No.' => ++$counter,
                'Reference Number' => $ticket->trackid ?? '',
                'Title' => $ticket->subject ?? '',
                'Details' => strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $ticket->message ?? '')),
                'Complaint Date' => \Carbon\Carbon::parse($ticket->dt)->format('d/m/Y H:i:s'),
                'First Response Date' => $firstResponseDate,
                'Category' => $categoryName,
                'Status' => $this->getStatusText($ticket->status),
                'Priority' => $this->getPriorityText($ticket->priority),
                'Customer Name' => $ticket->name ?? '',
                'Customer Email' => $ticket->email ?? '',
                'Owner' => $ownerName,
                'Date Updated' => \Carbon\Carbon::parse($ticket->lastchange)->format('d/m/Y H:i:s'),
                'Time Worked' => $ticket->time_worked ?? '0',
                'Replies Count' => $ticket->replies ?? 0,
            ];
        });
    }

    private function getStatusText($status)
    {
        $statusLookup = \App\Models\LookupStatusLog::find($status);
        return $statusLookup ? $statusLookup->nama : 'New';
    }

    private function getPriorityText($priority)
    {
        switch ($priority) {
            case '1': return 'High';
            case '2': return 'Medium';
            case '3': return 'Low';
            default: return 'Normal';
        }
    }

    /**
     * Apply custom field filters to query
     */
    private function applyCustomFieldFilters($query, $request)
    {
        $customFields = CustomField::getFilterableFields();
        
        foreach ($customFields as $field) {
            $paramName = 'custom_field_' . $field->id;
            
            if ($request->filled($paramName) && !in_array('all', $request->$paramName)) {
                $values = $request->$paramName;
                $columnName = 'custom' . $field->id;
                
                if ($field->type === 'checkbox') {
                    // For checkbox fields, use LIKE query for multiple values
                    $query->where(function($q) use ($columnName, $values) {
                        foreach ($values as $value) {
                            $q->orWhere($columnName, 'LIKE', '%' . addslashes($value) . '%');
                        }
                    })
                    // Exclude empty values for checkbox fields
                    ->whereNotNull($columnName)
                    ->where($columnName, '!=', '')
                    ->where($columnName, '!=', '0');
                } else {
                    // For radio and select fields, use exact match and exclude empty values
                    $query->whereIn($columnName, $values)
                        ->whereNotNull($columnName)
                        ->where($columnName, '!=', '')
                        ->where($columnName, '!=', '0');
                }
            }
        }
    }
}
