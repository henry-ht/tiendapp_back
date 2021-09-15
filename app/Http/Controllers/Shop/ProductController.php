<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $credentials = $request->only([
            'search'
        ]);

        $validation = Validator::make($credentials,[
            'search'    => 'sometimes|required|min:2|max:20'
        ]);

        if (!$validation->fails()) {

            $response  = Product::with(['brand'])/* ->query() */;

            if (isset($credentials['search'])) {
                $search = '%'.$credentials['search'].'%';
                $response
                ->orWhere('name', 'LIKE', $search)
            }

            $message    = ['message' => [__('list'), ]];
            $status     = 'success';
            $data       = $response->paginate(30);

        }else{
            $message    = $validation->messages();
            $status     = 'warning';
            $data       = false;

        }

        return response([
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
