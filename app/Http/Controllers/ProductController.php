<?php

namespace App\Http\Controllers;

use App\models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\WarehouseReceive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\models\Product_warehouse;
use App\models\Warehouse;
use App\models\Product_variants;
use App\models\Variants;
use App\models\SubVariant;
use App\models\AutoGenerate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::Userid()->paginate(500);
        $products->transform(function ($product) {
            if ($product->active == 0 || $product->active == null) {
                $product->active = false;
            } else {
                $product->active = true;
            }
            if ($product->lot == 0 || $product->lot == null) {
                $product->lot = false;
            } else {
                $product->lot = true;
            }
            if ($product->dangerous == 0 || $product->dangerous == null) {
                $product->dangerous = false;
            } else {
                $product->dangerous = true;
            }
            if ($product->has_serial == 0 || $product->has_serial == null) {
                $product->has_serial = false;
            } else {
                $product->has_serial = true;
            }
            $onhand = Product_warehouse::where('product_id', $product->id)->sum('onhand');
            // dd($onhand);
            // $product->onhand = $onhand;
            $product->onhand = ($onhand) ? $onhand : 0;
            $awaiting_stoke = WarehouseReceive::where('products_id', $product->id)->sum('qty');
            $product->awaiting_stoke = $awaiting_stoke;
            return $product;
        });
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'product_name' => 'required|unique:products',
            'client_id' => 'required',
            'sku_no' => 'required|unique:products',
        ]);
        // return $request->all();
        $product = new Product;
        $product->product_name = $request->product_name;
        $product->client_id = $request->client_id;
        $product->sku_no = $this->uniqueSku();;
        $product->user_id = Auth::id();
        $product->instructions = 'Product created by ' . Auth::user()->name;
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::Userid()->Userid()->where('id', $id)->get();
        $products->transform(function ($product) {
            if ($product->has_variants) {
                $product_val = Product_variants::where('product_id', $product->id)->get();
                // dd($product_val);
                $product_val->transform(function ($pro_val) {
                    $pro_val->variants = Variants::setEagerLoads([])->select('id', 'title')->where('id', $pro_val->variant_id)->get();
                    $pro_val->subvariants = SubVariant::select('id', 'title')->where('id', $pro_val->subvariant_id)->get();
                    // dd($pro_val->subvariant_id);
                    return $pro_val;
                });
                $product->variants = $product_val;
            }
            $onhand = Product_warehouse::where('product_id', $product->id)->sum('onhand');
            // dd($onhand);
            $product->onhand = $onhand;
            $product->dangerous = ($product->dangerous == 1) ? true : false;
            $product->lot = ($product->lot == 1) ? true : false;
            $product->digital = ($product->digital == 1) ? true : false;
            $product->has_serial = ($product->has_serial == 1) ? true : false;
            $product->active = ($product->active == 1) ? true : false;
            $onhand = Product_warehouse::where('product_id', $product->id)->sum('onhand');
            // dd($onhand);
            $product->onhand = ($onhand) ? $onhand : 0;
            // $product->onhand = $onhand;
            return $product;
        });
        return $products[0];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $variant = $request->form['variants_d'];
        // foreach ($variant as $key => $value) {
        //     foreach ($value['subvariants'] as $var_val) {
        //         // dd($value['variants'], $var_val);
        //         $product_variant  = new Product_variants();
        //         $product_variant->product_id = $id;
        //         $product_variant->subvariant_id = $var_val;
        //         $product_variant->variant_id = $value['variants'];
        //         $product_variant->save();
        //     }
        // }
        // return $request->all();
        $product = Product::find($id);
        $product->active = ($request->product['active']) ? 1 : 0;
        $product->dangerous = ($request->product['dangerous']) ? 1 : 0;
        $product->has_serial = ($request->product['has_serial']) ? 1 : 0;
        $product->lot = ($request->product['lot']) ? 1 : 0;
        $product->digital = ($request->product['digital']) ? 1 : 0;
        // $product->active = $request->product['active'];
        $product->box_id = $request->product['box_id'];
        $product->bar_code = $request->product['bar_code'];
        $product->classification_id = $request->product['classification_id'];
        $product->height = $request->product['height'];
        $product->length = $request->product['length'];
        // $product->lot = $request->product['lot'];
        $product->description = $request->product['description'];
        // $product->has_serial = $request->product['has_serial'];
        $product->product_name = $request->product['product_name'];
        $product->product_type = $request->product['product_type'];
        $product->reorder_point = $request->product['reorder_point'];
        $product->tariff_code = $request->product['tariff_code'];
        $product->sku_no = $request->product['sku_no'];
        $product->value = $request->product['value'];
        $product->price = $request->product['value'];
        $product->weight = $request->product['weight'];
        $product->width = $request->product['width'];
        $product->has_variants = $request->product['has_variants'];
        // dd($product->getDirty());
        $product->instructions = 'Product details updated by ' . Auth::user()->name;
        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function filterproducts(Request $request)
    {
        // return $request->all();
        $search = $request->search;
        $products = Product::Userid()->where('product_name', 'LIKE', "%{$search}%")->take(500)->get();
        $products->transform(function ($product) {
            $onhand = Product_warehouse::where('product_id', $product->id)->sum('onhand');
            // dd($onhand);
            $product->onhand = ($onhand) ? $onhand : 0;
            // $product->onhand = $onhand;
            return $product;
        });
        return $products;
    }
    public function searchItems(Request $request, $search)
    {
        // return $request->all();
        // return $search;
        $products = Product::Userid()->where('product_name', 'LIKE', "%{$search}%")->get();
        // return $products;
        $products->transform(function ($product) use ($request) {
            $warehouse = Warehouse::where('name', $request->transfer_from)->first();
            if ($request->warehouse) {
                $onhand = Product_warehouse::where('warehouse_id', $request->warehouse)->where('product_id', $product->id)->sum('onhand');
            } else {
                $onhand = Product_warehouse::where('warehouse_id', $warehouse->id)->where('product_id', $product->id)->sum('onhand');
            }
            // dd($onhand);
            $product->onhand = ($onhand) ? $onhand : 0;
            // $product->onhand = $onhand;
            return $product;
        });
        return $products;
    }


    public function pro_image(Request $request, $id)
    {
        // dd($request->image);
        $upload = Product::find($id);
        if ($request->hasFile('image')) {
            // return('test');
            // $imagename = time() . $request->image->getClientOriginalName();
            // $request->image->storeAs('public/test', $imagename);
            $img = $request->image;
            // $image_path = ;

            // $exists = Storage::disk('public')->exists($upload->image);

            // dd($exists, $upload->image);
            if (File::exists('storage/products/' . $upload->image)) {
                // return('test');
                $image_path = 'storage/products/' . $upload->image;
                File::delete($image_path);
                // return $image_path;
            }
            // $imagename =  Storage::disk('uploads')->put('products', $img);
            $imagename = Storage::disk('public')->put('products', $img);
        }

        // return('noop');
        $imgArr = explode('/', $imagename);
        $image_name = $imgArr[1];
        $upload->image = '/storage/products/' . $image_name;
        $upload->save();
        return $upload;
    }

    public function uniqueSku()
    {
        $product = Product::select('id')->orderBy('id', 'Desc')->first();
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $product = ($product) ? 'MFT_' . str_pad($product->id + 1, 8, "0", STR_PAD_LEFT) : 'MFT_' . str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['sku_no' => $product], ['sku_no' => 'unique:products,sku_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $product;
        // dd($product);
    }

    public function randomId()
    {
        $id = str_random(10);
        $validator = \Validator::make(['sku_no' => $id], ['sku_no' => 'unique:products,sku_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $id;
    }

    public function filterProd_table(Request $request)
    {
        // return $request->all();
        if ($request->req == 'all') {
            $products = Product::Userid()->paginate(500);
        } else if ($request->req == 'inactive') {
            $products = Product::Userid()->where('active', false)->paginate(500);
        } else {
            $products = Product::Userid()->where($request->req, true)->paginate(500);
        }
        $products->transform(function ($product) {
            if ($product->active == 0 || $product->active == null) {
                $product->active = false;
            } else {
                $product->active = true;
            }
            if ($product->lot == 0 || $product->lot == null) {
                $product->lot = false;
            } else {
                $product->lot = true;
            }
            if ($product->dangerous == 0 || $product->dangerous == null) {
                $product->dangerous = false;
            } else {
                $product->dangerous = true;
            }
            if ($product->has_serial == 0 || $product->has_serial == null) {
                $product->has_serial = false;
            } else {
                $product->has_serial = true;
            }
            $onhand = Product_warehouse::where('product_id', $product->id)->sum('onhand');
            // dd($onhand);
            $product->onhand = ($onhand) ? $onhand : 0;
            // $product->onhand = $onhand;
            $awaiting_stoke = WarehouseReceive::where('products_id', $product->id)->sum('qty');
            $product->awaiting_stoke = $awaiting_stoke;
            return $product;
        });
        return $products;
    }

    public function activate(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->active = true;
            $product->save();
        }
    }

    public function deactivate(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->active = false;
            $product->save();
        }
    }

    public function digital(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->digital = true;
            $product->save();
        }
    }
    public function notdigital(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->digital = false;
            $product->save();
        }
    }

    public function dangerous(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->dangerous = true;
            $product->save();
        }
    }
    public function notdangerous(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->dangerous = false;
            $product->save();
        }
    }

    public function lot(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->lot = true;
            $product->save();
        }
    }
    public function notlot(Request $request)
    {
        // return $request->all();
        $products = $request->all();
        foreach ($products as $product) {
            $product = Product::find($product['id']);
            $product->lot = false;
            $product->save();
        }
    }

    public function commited()
    { }

    public function unique_sku()
    {
        $product = Product::select('id')->orderBy('id', 'Desc')->first();
        return $product->id;
        // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        $product = ($product) ? str_pad($product->id + 1, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
        $validator = \Validator::make(['sku_no' => $product], ['sku_no' => 'unique:products,sku_no']);
        if ($validator->fails()) {
            return $this->randomId();
        }
        return $product;
    }

    public function uniquesku_no()
    {
        $gen = new AutoGenerate;
        return $gen->uniqueSku();
        // $product = Product::select('id')->orderBy('id', 'Desc')->first();
        // // return $product->id;
        // // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
        // $product = ($product) ? str_pad($product->id + 1, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
        // $validator = \Validator::make(['sku_no' => $product], ['sku_no' => 'unique:products,sku_no']);
        // if ($validator->fails()) {
        //     return $this->randomId();
        // }
        // return $product;
    }

    public function product_group(Request $request)
    {
        // return $request->all();
        foreach ($request->itemAttribute_arr as $key => $value) {
            // dd($value['item_name']);
            $product = new Product;
            $product->product_name = $value['item_name'];
            $product->description = $request->description;
            $product->price = $value['price'];
            $product->value = $value['price'];
            $product->sku_no = $value['sku_no'];
            $product->reorder_point = $value['reorder_point'];
            $product->user_id = Auth::id();
            $product->instructions = 'Product created by ' . Auth::user()->name;
            $product->save();
        }
    }
}

