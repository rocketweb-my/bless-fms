<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Ticket;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomFieldController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
            //Datatable

            $data = CustomField::whereIn('use', ['1','2'])->orderBy('order','ASC')->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('field_name', function ($data) {

                    return json_decode($data->name)->English;
                })

                ->addColumn('field_type', function ($data) {

                    switch ($data->type)
                    {
                        case 'text':
                            return 'Text Field';
                        case 'textarea':
                            return 'Text Area';
                        case 'radio':
                            return 'Radio Button';
                        case 'select':
                            return 'Select Box';
                        case 'checkbox':
                            return 'Checkbox';
                        case 'email':
                            return 'Email';
                        case 'date':
                            return 'Date';
                        case 'hidden':
                            return 'Hidden';
                        default:
                            return false;
                    }
                })

                ->addColumn('visibility', function ($data) {

                    if ($data->use == 1)
                    {
                        return 'Public';
                    }else{
                        return 'Staff Only';
                    }

                })

                ->addColumn('required', function ($data) {

                    if ($data->req == 1)
                    {
                        return 'For Customers';
                    }elseif($data->req == 2)
                    {
                        return 'Yes';
                    }else{
                        return 'No';
                    }

                })

                ->addColumn('category', function ($data) {

                    if ($data->category == null)
                    {
                        return 'All';
                    }else{
                        return 'Selected';
                    }

                })

                ->addColumn('position', function ($data) {

                    if ($data->place == 1)
                    {
                        return 'After Message';
                    }else{
                        return 'Before Message';
                    }

                })

                ->addColumn('action', function ($data) {
                    $btn = '<button class="btn btn-icon btn-success" data-id="'.$data->id.'" data-name='.json_encode($data->name).' data-use="'.$data->use.'" data-type="'.$data->type.'" data-type="'.$data->req.'" data-type="'.$data->category.'" data-type="'.$data->name.'" data-type="'.$data->value.'" data-toggle="modal" data-target="#editCustomFieldModal" id="edit"><i class="fa fa-pencil-square-o"></i></button>';
                    $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })

                ->rawColumns(['field_name','field_type','visibility','required','category','action'])
                ->make(true);
        }

        return view('pages.custom_field');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        // $custom_field = CustomField::where('use', '0')->orderBy('id', 'ASC')->first();
//        $order = CustomField::where('use', '!=' , '0')->orderBy('order','DESC')->first();
//        if ($order == null)
//        {
//            $current_order = 10;
//        }else{
//            $current_order = $order->order + 10;
//        }
        $custom_field = new CustomField();

        if ($custom_field == null) {
            return redirect()->back()->withErrors('Cannot add more than 50 custom field');
        }

        $name = json_encode([
            'English' => $request->name
        ]);

        $custom_field->use = $request->use;
        $custom_field->name = $name;
        $custom_field->type = $request->type;
        $custom_field->place = $request->place;
        $custom_field->req = $request->req;
        $custom_field->order = '990';

        switch ($request->type) {
            case 'text':

                if ($request->max_length == null)
                {
                    $max_length = '';
                }else{
                    $max_length = $request->max_length;
                }

                if ($request->default_value == null)
                {
                    $default_value = '';
                }else{
                    $default_value = $request->default_value;
                }

                $value = json_encode([
                    'max_length' => $max_length,
                    'default_value' => $default_value
                ]);

                break;
            case 'textarea':

                if ($request->rows == null)
                {
                    $rows = '';
                }else{
                    $rows = $request->rows;
                }

                if ($request->cols == null)
                {
                    $cols = '';
                }else{
                    $cols = $request->cols;
                }

                $value = json_encode([
                    'rows' => $rows,
                    'cols' => $cols,
                ]);

                break;
            case 'radio':

                $radio_options = preg_split("/\\r\\n|\\r|\\n/", $request->radio_options);
                $value = json_encode([
                   'radio_options' => $radio_options,
                   'no_default' => 0
                ]);

                break;
            case 'select':

                $select_options = preg_split("/\\r\\n|\\r|\\n/", $request->select_options);
                $value = json_encode([
                    'show_select' => 0,
                    'select_options' => $select_options
                ]);

                break;
            case 'checkbox':

                $checkbox_options = preg_split("/\\r\\n|\\r|\\n/", $request->checkbox_options);
                $value = json_encode([
                    'checkbox_options' => $checkbox_options
                ]);

                break;
            case 'email':

                $value = json_encode([
                    'multiple' => 0,
                ]);
                break;
            case 'hidden':

                if ($request->hidden_default_value == null)
                {
                    $default_value = '';
                }else{
                    $default_value = $request->hidden_default_value;
                }

                $value = json_encode([
                    'max_length' => 255,
                    'default_value' => $default_value
                ]);

                break;
        }


        if ($request->category == 0)
        {
            $custom_field->category = null;
        }

        $custom_field->value = $value;
        $custom_field->save();
        $this->update_order();

        flash('Custom Field Successfully Created', 'success');
        return redirect()->back();

    }

    public function update_order()
    {
        // Get list of current custom fields
        $datas = CustomField::select('id')->whereIn('use',['1','2'])->orderBy('place','ASC')->orderBy('order','ASC')->get();

        // Update database
        $i = 10;
        foreach ($datas as $data)
        {
            $cf = CustomField::find($data->id);
            $cf->order = $i;
            $cf->save();
            $i += 10;

        }

        CustomField::where('use','0')->update(['order' => 1000]);

        return true;

    }

    public function get_data(Request $request)
    {
        $custom_field = CustomField::find($request->id);
        return $custom_field;
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $custom_field = CustomField::find($request->id);


        $name = json_encode([
            'English' => $request->name
        ]);

        $custom_field->use = $request->use;
        $custom_field->name = $name;
        $custom_field->type = $request->type;
        $custom_field->place = $request->place;
        $custom_field->req = $request->req;

        switch ($request->type) {
            case 'text':

                if ($request->max_length == null)
                {
                    $max_length = '';
                }else{
                    $max_length = $request->max_length;
                }

                if ($request->default_value == null)
                {
                    $default_value = '';
                }else{
                    $default_value = $request->default_value;
                }

                $value = json_encode([
                    'max_length' => $max_length,
                    'default_value' => $default_value
                ]);

                break;
            case 'textarea':

                if ($request->rows == null)
                {
                    $rows = '';
                }else{
                    $rows = $request->rows;
                }

                if ($request->cols == null)
                {
                    $cols = '';
                }else{
                    $cols = $request->cols;
                }

                $value = json_encode([
                    'rows' => $rows,
                    'cols' => $cols,
                ]);

                break;
            case 'radio':

                $radio_options = preg_split("/\\r\\n|\\r|\\n/", $request->radio_options);
                $value = json_encode([
                    'radio_options' => $radio_options,
                    'no_default' => 0
                ]);

                break;
            case 'select':

                $select_options = preg_split("/\\r\\n|\\r|\\n/", $request->select_options);
                $value = json_encode([
                    'show_select' => 0,
                    'select_options' => $select_options
                ]);

                break;
            case 'checkbox':

                $checkbox_options = preg_split("/\\r\\n|\\r|\\n/", $request->checkbox_options);
                $value = json_encode([
                    'checkbox_options' => $checkbox_options
                ]);

                break;
            case 'email':

                $value = json_encode([
                    'multiple' => 0,
                ]);
                break;
            case 'hidden':

                if ($request->hidden_default_value == null)
                {
                    $default_value = '';
                }else{
                    $default_value = $request->hidden_default_value;
                }

                $value = json_encode([
                    'max_length' => 255,
                    'default_value' => $default_value
                ]);

                break;
        }


        if ($request->category == 0)
        {
            $custom_field->category = null;
        }

        $custom_field->value = $value;
        $custom_field->save();

        flash('Custom Field Successfully Update', 'success');
        return redirect()->back();

    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $custom_field = CustomField::find($id);
        $custom_field->use = '0';
        $custom_field->place = '0';
        $custom_field->type = 'text';
        $custom_field->req = '0';
        $custom_field->category = NULL;
        $custom_field->name = '';
        $custom_field->value = NULL;
        $custom_field->order = 1000;

        $custom_field->save();

        $this->update_order();

        DB::table('tickets')->update(['custom'.$id => '']);

        flash('Custom Field Successfully Deleted', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);

    }


}
