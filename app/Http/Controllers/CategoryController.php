<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if (user()->isadmin != 1 ||userPermissionChecker('can_man_cat') == false)
        {
            return redirect()->route('dashboard.index')->withErrors('You Do Not Have Permission To Manage Category');
        }

        if ($request->ajax()) {
            //Datatable
            $data = Category::orderBy('cat_order', 'ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('priority_edit', function ($data) {
                    $priorityName = getPriorityName($data->priority) ?: 'Unknown';
                    $badgeClass = match($data->priority) {
                        1 => 'badge-danger',
                        2 => 'badge-success', 
                        3 => 'badge-default',
                        default => 'badge-secondary'
                    };
                    return '<span class="badge ' . $badgeClass . ' mr-1 mb-1 mt-1">' . $priorityName . '</span>';
                })

                ->addColumn('type_edit', function ($data) {

                    if ($data->type == 0)
                    {
                        $type = '<span class="badge badge-info  mr-1 mb-1 mt-1">Public</span>';
                    }else
                    {
                        $type = '<span class="badge badge-primary  mr-1 mb-1 mt-1">Private</span>';
                    }

                    return $type;
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

                ->addColumn('total_ticket', function ($data) {

                    $total_ticket_by_category = totalTicketByCategory($data->id);
                    return $total_ticket_by_category;
                })

                ->addColumn('action', function ($data) {
                    $btn = '<button
                                class="btn btn-icon btn-success"
                                data-id="'.$data->id.'"
                                data-name="'.htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8').'"
                                data-priority="'.$data->priority.'"
                                data-type="'.$data->type.'"
                                data-autoassign="'.$data->autoassign.'"
                                data-toggle="modal"
                                data-target="#editCategory"
                                id="edit">
                                <i class="fa fa-pencil-square-o"></i>
                            </button>';
                    if ($data->id != 1) {
                        $btn .= '&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    }
                    return $btn;
                })


                ->rawColumns(['priority_edit','type_edit','autoassign_edit','total_ticket','action'])
                ->make(true);
        }

        return view('pages.category');
    }

    public function store(Request $request)
    {
        if($request->has('autoassign'))
        {
            $autoassign = $request->autoassign;
        }else{
            $autoassign = 0;
        }

        $res = Category::orderBy('cat_order', 'DESC')->first();
        $my_order = $res !== null ? $res->cat_order + 10 : 10;

        Category::create([
            'name'          => $request->name,
            'cat_order'     => $my_order,
            'autoassign'    => $autoassign,
            'type'          => $request->type,
            'priority'      => $request->priority,
        ]);

        flash('Category Successfully Added', 'success');
        return redirect()->route('category.index');
    }

    public function edit(Request $request)
    {
       $category = Category::find($request->id);
       $category->name = $request->name;
       $category->priority = $request->priority;
       $category->type = $request->type;
       $category->autoassign = $request->autoassign;
       $category->save();

        flash('Category Successfully Updated', 'success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();

        $ticket = Ticket::where('category',$request->id)
                            ->update(['category' => 1]);

        flash('Category Successfully Deleted', 'success');
        return redirect()->back();
    }


    public function get_to_edit(Request $request)
    {
        $category = Category::find($request->id);
        return $category;
    }
}
