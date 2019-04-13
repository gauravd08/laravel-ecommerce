<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\ProductSpecification;
use Image;
use Illuminate\Support\Facades\File;

class ProductsController extends \App\Http\Controllers\Controller
{
    /**
     * Validation Rules
     */
    public $rules = array(
        'category_id'          => ['required'],
        'brand_id'          => ['required'],
        'product_name'          => ['required'],
        'description'          => ['required'],
        'price'                => ['required']
    );

    
    /**
	 * 
	 * @param type
	 * @return type
	 * faq summary
	 */
    public function index()
    {
        $title = "Products";
        return view('Admin.Products.index')->with(compact('title'));
    }

     /**
     * faq Category Summary
     */
    public function ajaxIndex(Request $request)
    {
        $columns = array('id', 'brand_name', 'is_active', 'action');

        $totalFiltered = $totalData = Product::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $records = Product::offset($start)->limit($limit)->orderBy($order, $dir)->get();
        }
        else
        {
            $search = $request->input('search.value');
            $records = Product::where('brand_name', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->orderBy($order, $dir)->get();
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
            //dd($request->images[0]);
            $validator = Validator::make(Input::all(), $this->rules);
            $record = new Product();
            $record->product_name = $request->product_name;
            $record->description =$request->description;
            $record->slug = $this->createSlug($request->product_name);
            $record->category_id = $request->category_id;
            $record->brand_id = $request->brand_id;
            $record->price = $request->price;
            $record->is_active = $request->is_active ? 1 : 0;
            if ($validator->passes() && $record->save())
            {
                $productSpecification = new ProductSpecification();
                $productSpecification->product_id =  $record->id;
                $productSpecification->xs_quantity =  $request->xs_quantity;
                $productSpecification->s_quantity =  $request->s_quantity;
                $productSpecification->m_quantity =  $request->m_quantity;
                $productSpecification->l_quantity =  $request->l_quantity;
                $productSpecification->xl_quantity =  $request->xl_quantity;
                $productSpecification->xxl_quantity =  $request->xxl_quantity;
                if($productSpecification->save())
                {
                    
                    $i = 1;
                    $this->_uploadProductImage($request->images[0], PRODUCT_IMAGE_UPLOAD_PATH , $record->id, 500, 775);
                    
                    foreach($request->images as $image)
                    {
                        $this->_uploadProductImage($image, PRODUCT_IMAGE_UPLOAD_PATH . $record->id . '/', $i, 1000, 1358);
                        $this->_uploadProductImage($image, PRODUCT_IMAGE_UPLOAD_PATH . $record->id . '/', 'thumb-'.$i, 116, 116);

                        $productImage = new ProductImage();
                        $productImage->product_id = $record->id;
                        $productImage->image = $i;
                        $productImage->display_order = $i;
                        $productImage->save();
                        $i++;
                    }
                    return redirect('/admin/products')->with(['level' => 'success', 'content' => "Record added successfully"]);
                }


                
            }
            else
            {
                return back()->with(['level' => 'danger', 'content' => "Unable to save,  Please check the below form for detailed errors."])
                        ->withErrors($validator)->withInput(Input::all());
            }
        }
            
        $title = "Add Product";
        $allCategories = $this->_getCategories();
        $allBrands = $this->_getBrands();

        return view('Admin.Products.form')->with(compact('title', 'allCategories', 'allBrands'));
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

    private function _getCategories()
    {
        return Category::where('parent_id', '!=', 0)->pluck('category_name', 'id'); 
    }

    private function _getBrands()
    {
        return Brand::pluck('brand_name', 'id'); 
    }

    private function _uploadProductImage($image, $path, $imageName, $width, $height)
    {
        
        if(!File::exists($path))
        {
            File::makeDirectory($path, 0777, true);
        }
                
        return $this->_resizeAndSave($image, $path, $imageName, $width, $height);
    }

    private function _resizeAndSave($img, $path, $name, $width, $height)
    {
        $filename = $name . '.' . $img->getClientOriginalExtension();
        
        $canvas = Image::canvas($width, $height);
        $imgObj = Image::make($img->getRealPath());
        
        //Resize image maintaining aspect ratio
        $imgObj->resize($width, $height, function ($c) 
        {
            $c->aspectRatio();
        });

        //insert resized image centered into background
        $canvas->insert($imgObj, 'center');
        $canvas->save($path . $filename);
        
        return $filename;
    }
}
