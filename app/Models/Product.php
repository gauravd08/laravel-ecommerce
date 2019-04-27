<?php
namespace App\Models;

class Product extends AppModel
{
    public function ProductImage()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function ProductSpecification()
    {
        return $this->hasMany('App\Models\ProductSpecification');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
