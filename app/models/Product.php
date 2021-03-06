<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    public $with = ['images', 'reviews'];
    // public function brand()
    // {
    //     return $this->belongsTo('App\models\Brand', 'brand_id');
    // }
    public function subCategory()
    {
        return $this->belongsTo('App\models\SupCategory', 'subcategory_id');
    }

    public function category()
    {
        return $this->belongsTo('App\models\Category', 'category_id');
    }

    public function images()
    {
        return $this->hasMany('App\models\Productimg', 'product_id');
    }
    public function wishes()
    {
        return $this->hasMany('App\models\Wish', 'product_id');
    }
    public function sizes()
    {
        return $this->belongsToMany('App\models\Size', 'size_products', 'product_id', 'size_id');
    }
    public function reviews()
    {
        return $this->hasMany('App\models\Review', 'product_id');
    }

    public function sales()
    {
        return $this->hasMany('App\models\Sale', 'product_id');
    }

    public function scopeUserid($query)
    {
        // dd(Auth::user()->hasRole('Admin'));
        if (!Auth::user()->hasRole('Admin')) {
            // return $query->where('user_id', Auth::id());
            return $query->where('company_id',  Auth::user()->company_id);

        }
    }

    /**
     * The variants that belong to the user.
     */
    public function variants()
    {
        return $this->belongsToMany('App\models\Variant', 'product_variants');
    }
}
