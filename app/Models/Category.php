<?php
namespace App\Models;

class Category extends AppModel
{
    public function getParentCategories()
    {
        return Category::where('parent_id', '=', 0)->pluck('category_name', 'id'); 
    }

    public function getCategories()
    {
        return Category::where('parent_id', '!=', 0)->pluck('category_name', 'id'); 
    }
}
