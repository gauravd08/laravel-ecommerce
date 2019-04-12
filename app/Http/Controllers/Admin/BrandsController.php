<?php

namespace App\Http\Controllers\Admin;
use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;


class BrandsController extends \App\Http\Controllers\Controller
{
    /**
     * Validation Rules
     */
    public $rules = array(
        'brand_name'          => ['required'],
    );

    
    /**
	 * 
	 * @param type
	 * @return type
	 * faq summary
	 */
    public function index()
    {
        $title = "Brands";
        return view('Admin.Brands.index')->with(compact('title'));
    }

     /**
     * faq Category Summary
     */
    public function ajaxIndex(Request $request)
    {
        $columns = array('id', 'brand_name', 'is_active', 'action');

        $totalFiltered = $totalData = Brand::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $records = Brand::offset($start)->limit($limit)->orderBy($order, $dir)->get();
        }
        else
        {
            $search = $request->input('search.value');
            $records = Brand::where('brand_name', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->orderBy($order, $dir)->get();
            $totalFiltered = $records->count();
        }

        $data = array();
        if (!empty($records))
        {
            foreach ($records as $record)
            {
                $nestedData['id'] = $record->id;
                $nestedData['brand_name'] = $record->brand_name;
                if($record->is_active == 1)
                {
                    $nestedData['is_active'] ='<a href="/admin/brand/toggle/status/'.$record->id.'/'.$record->is_active.' " class="btn btn-success"> Active </a>';
                }
                else
                {
                    $nestedData['is_active'] = '<a href="/admin/brand/toggle/status/'.$record->id.'/'.$record->is_active.' " class="btn btn-danger"> Inactive </a>';
                }
                $nestedData['action'] = '<a href="/admin/brand/edit/'. $record->id .'" title="View" class="icon blue"><i class=" fa fa-edit fa-lg"></i></a> 
                                         &nbsp;
                                     <a class="icon blue deleteRecord" data-id= '.$record->id.' href="/admin/brand/delete/'.$record->id.'"><i class="fa fa-trash fa-lg"></i></a>';                      
               
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
	 * 
	 * @param type
	 * @return type
	 * add faq
	 */
	public function add(Request $request)
	{
        if($request->method() == 'POST')
        {
            $validator = Validator::make(Input::all(), $this->rules);
            $record = new Brand();
            $record->fill(Input::all());

            if ($validator->passes() && $record->save())
            {
                return redirect('/admin/brands')->with(['level' => 'success', 'content' => "Record added successfully"]);
            }
            else
            {
                return back()->with(['level' => 'danger', 'content' => "Unable to save,  Please check the below form for detailed errors."])
                        ->withErrors($validator)->withInput(Input::all());
            }
        }
            
        $title = "Add Faq";

        return view('Admin.Brands.form')->with(compact('title'));
	}
	
	 /**
	 * 
	 * @param type $id
	 * @return type
	 * edit faq
	 */
    public function edit($id, Request $request)
    {
        $record = Brand::findOrFail($id);

        if($request->method() == 'POST')
        {
            $validator = Validator::make(Input::all(), $this->rules);
            $record->fill(Input::all());

            if ($validator->passes() && $record->save())
            {
                return redirect('/admin/brands')->with(['level' => 'success', 'content' => "Record updated successfully"]);
            }
            else
            {
                return back()->with(['level' => 'danger', 'content' => "Unable to save,  Please check the below form for detailed errors."])
                        ->withErrors($validator)->withInput(Input::all());
            }
        }
        
        $title = "Edit Faq Category";
        
        return view('Admin.brands.form')->with(compact('record', 'title'));
    }
    
    //Delete Record
    public function deleteBrand(Request $request)
    {
        Brand::where('id', $request->id)->delete();
		
        return back()->with(['level' => 'success', 'content' =>  "Record deleted successfully"]);
    }

    //toggle active state
    public function toggleStatus(Brand $model, $status)
    {
        $model->is_active = !$status;

        $model->save();

        return back()->with(['level' => 'success', 'content' => "Status updated successfully"]);
    }
}
