<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use StaticArray;

class CategoriesController extends \App\Http\Controllers\Controller
{
    /**
     * Validation Rules
     */
    public $rules = array(
        'category_name'          => ['required'],
        'description'          => ['required']
    );

    /**
     * categories summary
     */
    public function index()
    {
        $title = "Categories";
        
        return view('Admin.Categories.index')->with(compact('title'));
    }
    
    /**
	 * 
	 * @param type
	 * @return type
     * graphic Summary
     */
    public function ajaxIndex(Request $request)
    {
        $columns = array('id', 'category_name', 'description', 'is_active', 'action');

        $totalFiltered = $totalData = Category::count();
        //print_r($totalFiltered);exit;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $records = Category::offset($start)->limit($limit)->orderBy($order, $dir)->get();
        }
        else
        {
            $search = $request->input('search.value');
            $records = Category::where('name', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->orderBy($order, $dir)->get();
            $totalFiltered = $records->count();
        }

        $data = array();
        if (!empty($records))
        {
            foreach ($records as $record)
            {
                $nestedData['id'] = $record->id;
                $nestedData['category_name'] = $record->category_name;
                $nestedData['description'] = $record->description;
                if($record->is_active == 1)
                {
                    $nestedData['is_active'] ='<a href="/admin/category/toggle/status/'.$record->id.'/'.$record->is_active.' " class="btn btn-success"> Active </a>';
                }
                else
                {
                    $nestedData['is_active'] = '<a href="/admin/category/toggle/status/'.$record->id.'/'.$record->is_active.' " class="btn btn-danger"> Inactive </a>';
                }
                $nestedData['action'] = '<a href="/admin/category/edit/'. $record->id .'?'.CSS_JS_VER.'" title="View" class="icon blue"><i class=" fa fa-edit"></i></a> <a onclick="return confirm(`Are you sure you want to delete this item?`)" href="/admin/graphics/delete/'. $record->id.'" title="View" class="icon blue"><i class="fa fa-trash fa-lg"></i></a>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    
    /**
     * Add category
     */
    public function add(Request $request)
    {
        if($request->method() == 'POST')
        {
            
            $validator = Validator::make(Input::all(), $this->rules);
           // dd(Input::all());
            if($validator->passes())
            {
                $record = new Category();
                $record->fill(Input::all());
                $record->slug = $this->createSlug($request->category_name);
                $record->parent_id = $request->parent_id ? $request->parent_id : 0;
                $record->is_active = $request->is_active ? 1 : 0;
                $record->save();
                return redirect('/admin/categories')->with(['level' => 'success', 'content' => "Record added successfully"]);
            }
            else
            {
                return back()->with(['level' => 'danger', 'content' => "Unable to save,  Please check the below form for detailed errors."])
                        ->withErrors($validator)->withInput(Input::all());
            }
        }
        
        $title = "Add Category";
        //get list of all parent categories
        $list = new Category();
        $parentCategoryList = $list->getParentCategories();
       
        return view('Admin.Categories.form')->with(compact('title', 'parentCategoryList'));
    }

   /**
	 * 
	 * @param type $id
	 * @return type
	 * edit category
	 */
    public function edit($id, Request $request)
    {
        $record = Category::findOrFail($id);

        if($request->method() == 'POST')
        {
                       
            $validator = Validator::make(Input::all(), $this->rules);
            
            $record->fill(Input::all());
            if($validator->passes() && $record->save())
            {
                return redirect('/admin/graphics')->with(['level' => 'success', 'content' => "Record added successfully"]);
            }
            else
            {
                return back()->with(['level' => 'danger', 'content' => "Unable to save,  Please check the below form for detailed errors."])
                        ->withErrors($validator)->withInput(Input::all());
            }
        }
        
        $title = "Edit Category";
        //get list of all parent categories
        $list = new Category();
        $parentCategoryList = $list->getParentCategories();
        
        return view('Admin.Categories.form')->with(compact('record', 'title', 'parentCategoryList'));
    }
    
    //Delete Record
    public function delete(Request $request)
    {
        Category::where('id', $request->id)->delete();
		
        return back()->with(['level' => 'success', 'content' =>  "Record deleted successfully"]);
    }

    //toggle active state
    public function toggleStatus(Category $model, $status)
    {
        $model->is_active = !$status;

        $model->save();

        return back()->with(['level' => 'success', 'content' => "Status updated successfully"]);
    }
}
