<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\KnowledgebaseCategory;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KnowledgebaseArticle;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KnowledgebaseAttachment;

class KnowledgebaseController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            //Datatable
            $data = KnowledgebaseArticle::orderBy('sticky', 'DESC')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('author', function ($data) {
                    $author = findUser($data->author);
                    if ($author == null)
                    {
                        return '';
                    }else{
                        return $author->name;
                    }

                })
                ->addColumn('date', function ($data) {
                    return Carbon::parse($data->dt)->format('d-m-Y');
                })
                ->addColumn('action', function ($data) {
                    $btn = '<form method="post" action="/knowledgebase/article/edit" id="kb'.$data->id.'"><input type="hidden" name="_token" value="'.csrf_token().'" /><input type="hidden" name="id" value="'.$data->id.'"></form>';
                    $btn = $btn.'<a class="btn btn-icon btn-info mr-1" href="'.route('knowledgebase.article.view',$data->id).'"><i class="fa fa-eye"></i></a>';
                    if (user()->isadmin == 1 || userPermissionChecker('can_man_kb') == true)
                    {
                        $btn = $btn.'<button class="btn btn-icon btn-success" type="submit" id="edit" form="kb'.$data->id.'"><i class="fa fa-pencil-square-o"></i></button>';
                        $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';
                    }
                    return $btn;
                })



                ->rawColumns(['action','date'])
                ->make(true);
        }
        return view('pages.knowledgebase');
    }

    public function article()
    {
        $kb_categories_db = KnowledgebaseCategory::all();
        $kb_categories_public_db = KnowledgebaseCategory::where('type','0')->get();
        $kb_categories_private_db = KnowledgebaseCategory::where('type','1')->get();
        $kb_categories_public = '';
        $kb_categories_private = '';
        $kb_categories_all = '';

        foreach ($kb_categories_db as $kb_cat )
        {
            $kb_categories_all = $kb_categories_all.'<option value="'.$kb_cat->id.'">'.$kb_cat->name.'</option>';
        }

        foreach ($kb_categories_private_db as $kb_cat_private )
        {
            $kb_categories_private = $kb_categories_private.'<option value="'.$kb_cat_private->id.'">'.$kb_cat_private->name.'</option>';
        }

        foreach ($kb_categories_public_db as $kb_cat_public )
        {
            $kb_categories_public = $kb_categories_public.'<option value="'.$kb_cat_public->id.'">'.$kb_cat_public->name.'</option>';
        }


//        $kb_categories_private =
        return view('pages.knowledgebase_add_article',compact('kb_categories_private','kb_categories_public','kb_categories_all'));
    }

    public function add_article(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'article' => 'required',
        ]);

        if ($request->keywords == null)
        {
            $keyword = '';
        }else{
            $keyword = $request->keywords;
        }

        $history = '<li class="smaller">'.Carbon::now().' | submitted by '.user()->name.' ('.user()->user.')</li>';


        $attachment_list = '';

        if($request->file()) {
            for ($x = 1; $x <= systemSetting()->attachments_max_size ; $x++) {
                {
                    if ($request->file[$x]??'') {
                    if ($request->file[$x] != "undefined") {
                        $save_file_name = $request->tracking_id.'_'.$request->file[$x]->hashName();
                        $path = $request->file[$x]->storeAs('public/attachment/knowledgebase',$save_file_name);
                        $file_size = $request->file[$x]->getSize();
                        $original_file_name = $request->file[$x]->getClientOriginalName();

                        $attachment = KnowledgebaseAttachment::create([
                            'saved_name'    => $save_file_name,
                            'real_name'     => $original_file_name,
                            'size'          => $file_size,
                        ]);

                        $attachment_list .= $attachment->id . '#' . $original_file_name .',';
                    }
                    }
                }
            }
        }

        $kb_category = KnowledgebaseCategory::find($request->category);
        $kb_category->articles += 1;
        $kb_category->save();

        KnowledgebaseArticle::create([
            'catid'     => $request->category,
            'dt'        => Carbon::now(),
            'author'    => user()->id,
            'subject'   => $request->subject,
            'content'   => $request->article,
            'keywords'  => $keyword,
            'type'      => $request->type,
            'sticky'    => $request->sticky,
            'history'    => $history,
            'attachments' => $attachment_list,
        ]);

        flash('Article Successfully Added', 'success');
        return redirect()->route('knowledgebase');
    }

    public function edit_article(Request $request)
    {

        $article = KnowledgebaseArticle::find($request->id);

        $kb_categories_db = KnowledgebaseCategory::all();
        $kb_categories_public_db = KnowledgebaseCategory::where('type','0')->get();
        $kb_categories_private_db = KnowledgebaseCategory::where('type','1')->get();
        $kb_categories_public = '';
        $kb_categories_private = '';
        $kb_categories_all = '';

        foreach ($kb_categories_db as $kb_cat )
        {
            if ($article->catid == $kb_cat->id)
            {
                $kb_categories_all = $kb_categories_all.'<option selected value="'.$kb_cat->id.'">'.$kb_cat->name.' </option>';
            }
            else{
                $kb_categories_all = $kb_categories_all.'<option value="'.$kb_cat->id.'">'.$kb_cat->name.' </option>';
            }
        }

        foreach ($kb_categories_private_db as $kb_cat_private )
        {
            if ($article->catid == $kb_cat_private->id)
            {
                $kb_categories_private = $kb_categories_private.'<option selected value="'.$kb_cat_private->id.'">'.$kb_cat_private->name.'</option>';
            }else{
                $kb_categories_private = $kb_categories_private.'<option value="'.$kb_cat_private->id.'">'.$kb_cat_private->name.'</option>';

            }
        }

        foreach ($kb_categories_public_db as $kb_cat_public )
        {
            if ($article->catid == $kb_cat_public->id)
            {
                $kb_categories_public = $kb_categories_public.'<option selected value="'.$kb_cat_public->id.'">'.$kb_cat_public->name.'</option>';

            }else{
                $kb_categories_public = $kb_categories_public.'<option value="'.$kb_cat_public->id.'">'.$kb_cat_public->name.'</option>';
            }
        }


        return view('pages.knowledgebase_edit_article',compact('article','kb_categories_all','kb_categories_private','kb_categories_public'));
    }

    public function save_edit_article(Request $request)
    {

        $request->validate([
            'subject' => 'required',
            'article' => 'required',
        ]);

        if ($request->keywords == null)
        {
            $keyword = '';
        }else{
            $keyword = $request->keywords;
        }

        $article = KnowledgebaseArticle::find($request->id);
        $article->subject   = $request->subject;
        $article->content   = $request->article;
        $article->keywords  = $keyword;
        $article->type      = $request->type;
        $article->sticky    = $request->sticky;
        $article->catid     = $request->category;
        $article->save();

        flash('Article Successfully Edited', 'success');
        return redirect()->route('knowledgebase');


    }

    public function delete_article(Request $request)
    {
        $article = KnowledgebaseArticle::find($request->id);
        $article->delete();
        flash('Article Successfully Deleted', 'success');
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function category(Request $request)
    {
        if ($request->ajax()) {
            //Datatable
            $data = KnowledgebaseCategory::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type_edit', function ($data) {
                    if ($data->type == 0)
                    {
                        $type = '<span class="badge badge-success  mr-1 mb-1 mt-1">Published</span>';
                    }else{
                        $type = '<span class="badge badge-primary  mr-1 mb-1 mt-1">Private</span>';

                    }
                    return $type;
                })
                ->addColumn('action', function ($data) {
                    $btn = '<button class="btn btn-icon btn-success" data-name="'.$data->name.'" data-id='.$data->id.' data-type='.$data->type.' data-toggle="modal" data-target="#editCategory" id="edit"><i class="fa fa-pencil-square-o"></i></button>';
                    if($data->id != 1)
                    {
                        $btn = $btn.'&nbsp; <button class="btn btn-icon btn-danger" data-id="'.$data->id.'" id="delete"><i class="fa fa-trash-o"></i></button>';

                    }
                    return $btn;
                })
                ->rawColumns(['action','type_edit'])

                ->make(true);
        }

        return view('pages.knowledgebase_category');
    }

    public function add_category(Request $request){


        $request->validate([
            'title' => 'required',
            'type' => 'required',
        ]);


        KnowledgebaseCategory::create([
            'name'  => $request->title,
            'parent'    => '0',
            'cat_order' => 10,
            'type'  => $request->type,
        ]);

        flash('Category Successfully Added', 'success');
        return redirect()->back();
    }

    public function edit_category(Request $request){

        $request->validate([
            'title' => 'required',
            'type' => 'required',
        ]);

        $kb_category = KnowledgebaseCategory::find($request->id);
        $kb_category->name = $request->title;
        $kb_category->type = $request->type;
        $kb_category->save();


        flash('Category Successfully Edited', 'success');
        return redirect()->back();
    }

    public function delete_category(Request $request){

        KnowledgebaseArticle::where('catid', $request->id)
            ->update(['catid' => 1]);

        $kb_article = KnowledgebaseArticle::where('catid', 1)->get();

        $kb_category_main = KnowledgebaseCategory::find(1);
        $kb_category_main->articles = $kb_article->count();
        $kb_category_main->save();

        $kb_category = KnowledgebaseCategory::find($request->id);

        $kb_category->delete();


        flash('Category Successfully Deleted', 'success');
        return redirect()->back();
    }

    public function view_article($id)
    {
        $article = KnowledgebaseArticle::find($id);
        $article->views += 1;
        $article->save();
        return view('pages.knowledgebase_view_article', compact('article'));
    }
}
