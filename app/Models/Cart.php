<?php
namespace App\Models;

class Cart extends AppModel
{
    public function Product()
    {
        return $this->belongsTo('App\Models\Product');
    }

}
