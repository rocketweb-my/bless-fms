<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{

    public function index(Request $request)
    {
        if (user()->isadmin != 1 ||userPermissionChecker('can_man_cat') == false)
        {
            return redirect()->route('dashboard.index')->withErrors('You Do Not Have Permission To Manage Sub Category');
        }

        if ($request->ajax()) {
            //Datatable
            $data = SubCategory::with('category')->orderBy('cat_order', 'ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', function ($data) {
                    return $data->category ? $data->category->name : 'N/A';
                })
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
                    $total_ticket_by_sub_category = Ticket::where('sub_category', $data->id)->count();
                    return $total_ticket_by_sub_category;
                })

                ->addColumn('action', function ($data) {
                    $btn = '<button
                                class="btn btn-icon btn-success"
                                data-id="'.$data->id.'"
                                data-name="'.htmlspecialchars($data->name, ENT_QUOTES, 'UTF-8').'"
                                data-category_id="'.$data->category_id.'"
                                data-priority="'.$data->priority.'"
                                data-type="'.$data->type.'"
                                data-autoassign="'.$data->autoassign.'"
                                data-toggle="modal"
                                data-target="#editSubCategory"
                                id="edit">
                                <i class="fa fa-pencil-square-o"></i>
                            </button>';
                    $btn .= '&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })


                ->rawColumns(['category_name','priority_edit','type_edit','autoassign_edit','total_ticket','action'])
                ->make(true);
        }

        $categories = Category::orderBy('cat_order', 'ASC')->get();
        return view('pages.sub_category', compact('categories'));
    }

    public function store(Request $request)
    {
        if($request->has('autoassign'))
        {
            $autoassign = $request->autoassign;
        }else{
            $autoassign = 0;
        }

        $res = SubCategory::orderBy('cat_order', 'DESC')->first();
        $my_order = $res !== null ? $res->cat_order + 10 : 10;

        SubCategory::create([
            'name'          => $request->name,
            'category_id'   => $request->category_id,
            'cat_order'     => $my_order,
            'autoassign'    => $autoassign,
            'type'          => $request->type,
            'priority'      => $request->priority,
        ]);

        flash('Sub Category Successfully Added', 'success');
        return redirect()->route('sub-category.index');
    }

    public function edit(Request $request)
    {
       $subCategory = SubCategory::find($request->id);
       $subCategory->name = $request->name;
       $subCategory->category_id = $request->category_id;
       $subCategory->priority = $request->priority;
       $subCategory->type = $request->type;
       $subCategory->autoassign = $request->autoassign;
       $subCategory->save();

        flash('Sub Category Successfully Updated', 'success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $subCategory = SubCategory::find($request->id);
        $subCategory->delete();

        $ticket = Ticket::where('sub_category',$request->id)
                            ->update(['sub_category' => null]);

        flash('Sub Category Successfully Deleted', 'success');
        return redirect()->back();
    }


    public function get_to_edit(Request $request)
    {
        $subCategory = SubCategory::find($request->id);
        return $subCategory;
    }

    public function getSubCategoriesByCategory($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
                                    ->orderBy('cat_order', 'ASC')
                                    ->get(['id', 'name']);
        return response()->json($subCategories);
    }
}