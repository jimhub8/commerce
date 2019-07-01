<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\Session;
use App\models\Category;
use App\models\Menu;

class FilterController extends Controller
{
    public function filterItem(Request $request)
    {
        // return $request->all();
        return Product::whereIn('subcategory_id', $request->all())->paginate(9);
    }
    public function filterProduct(Request $request, $id)
    {
        // return $request->all();
        return Product::where('subcategory_id', $id)->paginate(9);
    }

    public function filterItems(Request $request)
    {
        // return $request->all();
        if ($request->brand != null) {
            return Product::where('brand_id', $request->brand)->paginate(9);
        } elseif ($request->sub_cat) {
            return Product::where('subcategory_id', $request->sub_cat)->paginate(9);
        } elseif ($request->price) {
            return Product::whereBetween('price', $request->price)->paginate(9);
        } else {
            return 'noop';
        }
    }


    public function FilterShop(Request $request)
    {
        // return $request->all();
        // $wishList = Session::has('wish') ? Session::get('wish') : null;
        // $wish_id = [];
        // if (!empty($wishList)) {
        //     foreach ($wishList as $wish) {
        //         foreach ($wish as $value) {
        //             // return $value;
        //             $wish_id[] = $value->id;
        //         }
        //     }
        // }
        // return $wish_id;
        $price = $request->price['state'];
        $id = $request->item;
        if (!empty($request->itemSelect['abbr'])) {
            $item = $request->itemSelect['abbr'];
        } else {
            $item = $request->itemSelect['state'];
        }
        $menus = Category::where('menu_id', $id)->get();
        $cat_menu = $menus->map(function ($menu) {
			return $menu->only('id');
        });
        // return $cat_menu;
        // $item = $request->itemSelect['abbr'];
        // return Product::where('category_id', $request->id)->paginate(12);
        if (empty($id) && $price == 'All' && $item != 'All') {

            $products = Product::where($item, 1)->paginate(12);
            // return $products = Product::whereIn('category_id', $cat_menu)->paginate(12);
        } elseif (empty($id) && $price != 'All' && $item == 'All') {
            $price_a = explode('-', $price);
            $products = Product::whereBetween('price', $price_a)->paginate(12);
        } elseif (!empty($id) && $price == 'All' && $item == 'All') {
            return $products = Product::whereIn('category_id', $cat_menu)->paginate(12);
            // $category = Category::find($id);
            // return $category->products;
        } elseif (empty($id) && $price != 'All' && $item != 'All') {
            $price_a = explode('-', $price);
            $products = Product::whereBetween('price', $price_a)->where($item, 1)->paginate(12);
        } elseif (!empty($id) && $price = 'All' && $item != 'All') {
            $products = Product::where($item, 1)->whereIn('category_id', $cat_menu)->paginate(12);
        } elseif (!empty($id) && $price != 'All' && $item == 'All') {
            $price_a = explode('-', $price);
            $products = Product::whereBetween('price', $price_a)->whereIn('category_id', $cat_menu)->paginate(12);
        } elseif (!empty($id) && $price != 'All' && $item != 'All') {
            $price_a = explode('-', $price);
            $products = Product::where($item, 1)->whereBetween('price', $price_a)->whereIn('category_id', $cat_menu)->paginate(12);
        } else {
            $products = Product::paginate(12);
        }
        $products->transform(function ($product, $key) {
            // dd(unserialize($order->paypal['id']));
            // $order->paypal = unserialize($order->paypal);

            $wishList = Session::has('wish') ? Session::get('wish') : null;
            $wish_id = [];
            if (!empty($wishList)) {
                foreach ($wishList as $wish) {
                    foreach ($wish as $value) {
                    // dd($value);
                        $wish_id[] = $value['id'];
                    }
                }
            }




            if (in_array($product->id, $wish_id)) {
                $product->wish_list = 1;
            } else {
                $product->wish_list = 0;
            }
            
            // $product->wish_list = 1;
            return $product;
        });
        return $products;

    }

}
