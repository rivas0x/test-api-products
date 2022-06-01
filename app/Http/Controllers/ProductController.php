<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\ProductDetail;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(array(
            'status' => true,
            'data' => Product::with('details')->get()
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = isset($request->category_id) ? $request->category_id : '';
        $product->save();

        $detail = new ProductDetail;
        $detail->description = isset($request->description) ? $request->description : '';
        $detail->size = isset($request->size) ? $request->size : '';
        $detail->color = isset($request->color) ? $request->color : '';
        $detail->product_id = $product->id;
        $detail->save();

        return response()->json(array(
            'status' => true,
            'data' => array(
                'product' => $product,
                'detail'  => $detail
            )
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(array(
            'status' => true,
            'data' => $product->with('details')->get()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->name = isset($request->name) ? $request->name : $product->name;
        $product->price = isset($request->price) ? $request->price : $product->price;
        $product->update();

        if (isset($request->description) || isset($request->size) || isset($request->color)) {
            if (isset($request->detail_id)) {
                $detail = ProductDetail::where('id', '', $request->detail_id)->first();
            } else {
                $detail = new ProductDetail;
            }

            $detail->description = isset($request->description) ? $request->description : '';
            $detail->size = isset($request->size) ? $request->size : '';
            $detail->color = isset($request->color) ? $request->color : '';
            $detail->product_id = $product->id;

            if (isset($request->detail_id)) {
                $detail->update();
            } else {
                $detail->save();
            }
        }

        return response()->json(array(
            'status' => true,
            'data' => array(
                'product' => $product,
                'detail'  => isset($detail) ? $detail : null
            )
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return response()->json(array(
            'status' => true,
            'data' => $product->delete()
        ));
    }
}
