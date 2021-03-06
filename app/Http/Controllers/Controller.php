<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() 
    {
        $cartCount = $this->_cartCount();
        View::share('cartCount', $cartCount);
    }

    /**
     * Resizes and upload image
     * @param type $request
     * @param type $field
     * @param type $path
     * @param type $name
     * @param type $width
     * @param type $height
     * @return string
     */
    protected function resizeAndUploadImage($request, $field, $path, $name, $width, $height)
    {
        // echo $path;exit;
        //Create directory if not exists
        if(!File::exists($path))
        {
            File::makeDirectory($path, 0777, true);
        }
                
        $requestImg = $request->file($field);
        
        return $this->resizeAndSave($requestImg, $path, $name, $width, $height);
    }

    /**
     * Resizes and Save image in folder
     * @param type $img
     * @param type $path
     * @param type $name
     * @param type $width
     * @param type $height
     */
    protected function resizeAndSave($img, $path, $name, $width, $height)
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

    /**
     * create unique slug
     * @param string $name
     */
    protected function createSlug($name)
    {
        if ($name == trim($name) && strpos($name, ' ') !== false) 
        {
            $name = explode(' ', $name);
            foreach($name as $value)
            {
                $arr[] = strtolower($value);
            }
            
            $slug = implode('-', $arr);
        }
        else
        {
            $slug = strtolower($name);
        }
        return $slug;
    }

    /**
     * get cart count
     */
    private function _cartCount()
    {
        if(Auth::check())
        {
            echo "hi";exit;
            $count = Cart::where('user_id', Auth::user()->id)->count();
        }
        else
        {
            $count = 50;
        }
        
        return $count;
    }
}
