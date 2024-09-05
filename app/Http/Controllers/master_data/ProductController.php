<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;
use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\ProductRequest;
use App\Models\master_data\Unit;
use App\Models\master_data\Supplier;
use App\Models\master_data\Product_category;
use App\Models\master_data\Product;
use App\Models\master_data\Brand;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    protected $folder       = '';
    protected $controller   = '';
    protected $function     = '';

    public function __construct()
    {
        $route_name = explode('.', Route::currentRouteName());
        if(count($route_name) < 3) die('route not match');

        $this->folder     = $route_name[0];
        $this->controller = $route_name[1];
        $this->function   = $route_name[2];
        $this->imagePath  = 'minipos_product';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->folder.'.'.$this->controller.'_'.$this->function);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $product_category   = Product_category::dropdownNoCond()->prepend('','');
        $brand              = Brand::dropdownNoCond()->prepend('','');
        $unit               = Unit::dropdownNoCond()->prepend('','');
        $supplier           = Supplier::dropdown()->prepend('','');

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('product_category', 'brand', 'unit', 'supplier')
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $product                      = new Product;
            $product->product_category_id = $request->product_category;
            $product->brand_id            = $request->brand;
            $product->unit_id             = $request->unit;
            $product->supplier_id         = $request->supplier;
            $product->name                = $request->name;
            $product->code                = $request->code;
            $product->cost                = \Helper::number_formats($request->cost, 'db');
            $product->release_date        = \Helper::date_formats($request->release_date, 'db');
            $product->price               = \Helper::number_formats($request->price, 'db');
            $product->storage             = $request->storage;
            $product->description         = $request->description;
            $product->save();

            if ($request->hasFile('image')) {
                $image          = $request->file('image');
                $imagename      = 'PRODUCT_' . $product->id . '_'. time() . '.' . $image->getClientOriginalExtension();
                $product->image = $imagename;
                $product->save();

                $uploaded = $image->storeOnCloudinaryAs($this->imagePath, $imagename);
                $product->update(['image' => $uploaded->getSecurePath()]);
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            throw $e;
            //abort(403, $e->getMessage());
        }


        if ($success_trans == true) {

            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.saved'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $product = Product::find($product_id);
        $image   = $product->image;

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('product', 'image')
                );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $product_id
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        $product            = Product::find($product_id);
        $brand              = Brand::dropdownNoCond()->prepend('','');
        $product_category   = Product_category::dropdownNoCond()->prepend('','');
        $unit               = Unit::dropdownNoCond()->prepend('','');
        $supplier           = Supplier::dropdown()->prepend('','');

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('product', 'product_category','unit', 'supplier', 'brand'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $product_id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $product_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $product                      = Product::find($product_id);
            $product->product_category_id = $request->product_category;
            $product->brand_id            = $request->brand;
            $product->unit_id             = $request->unit;
            $product->supplier_id         = $request->supplier;
            $product->name                = $request->name;
            $product->code                = $request->code;
            $product->cost                = \Helper::number_formats($request->cost, 'db');
            $product->release_date        = \Helper::date_formats($request->release_date, 'db');
            $product->price               = \Helper::number_formats($request->price, 'db');
            $product->storage             = $request->storage;
            $product->description         = $request->description;
            $product->save();

            if ($request->hasFile('image')) {
                // DELETE OLD IMAGE
                $oldImage = $product->image;
                $publicId = pathinfo($oldImage, PATHINFO_FILENAME);
                Cloudinary::destroy($this->imagePath . '/' . $publicId);

                // UPLOAD NEW IMAGE
                $image          = $request->file('image');
                $imagename      = 'PRODUCT_' . $product->id . '_'. time() . '.' . $image->getClientOriginalExtension();
                $product->image = $imagename;
                $product->save();

                $uploaded = $image->storeOnCloudinaryAs($this->imagePath, $imagename);
                $product->update(['image' => $uploaded->getSecurePath()]);
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            abort(404);
            //abort(403, $e->getMessage());
        }

        if ($success_trans == true) {
            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.updated'));
        }
    }

    public function destroy($product_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $product = Product::find($product_id);
            if(empty($product)) return json_encode('product not found');

            $product->deleted_at   = date('Y-m-d H:i:s');
            $product->user_deleted = \Auth::id();
            $product->save();
            
            if($product->image) {
                // DELETE IMAGE
                $oldImage = $product->image;
                $publicId = pathinfo($oldImage, PATHINFO_FILENAME);
                Cloudinary::destroy($this->imagePath . '/' . $publicId);
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            
            // error response
            return json_encode($e->getMessage());
        }


        if ($success_trans == true) {
            return json_encode($success_trans);
        }

    }


    /**
    * Showing a list Menu by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){

            // get row number datatable
            $sql_no_urut = \Yajra_datatable::get_no_urut('products.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $product       = Product::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'products.id',
                                    'products.name',
                                    'brands.name AS brand_name',
                                    'product_categories.name AS product_category_name',
                                    'products.code'
                                ])
                                ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                                ->join('brands', 'brands.id', '=', 'products.brand_id')
                                ->whereNull('products.deleted_at');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Product';

                return Datatables::of($product)
                                    ->addColumn('action', function ($product) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$product,$permission,$remark);
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
