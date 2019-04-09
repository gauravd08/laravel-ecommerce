<?php
namespace App\Models;

class Category extends AppModel
{
    public function getParentCategories()
    {
        return Category::pluck('category_name', 'id')->where('pareant_id', '=', 0); 
    }
}
