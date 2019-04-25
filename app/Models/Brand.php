<?php
namespace App\Models;

class Brand extends AppModel
{
    public function getBrands()
    {
        return Brand::pluck('brand_name', 'id'); 
    }
}
