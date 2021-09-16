<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Validator;
use Illuminate\Http\Request;

class BrandController extends Controller
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

            $response  = Brand::withCount(['product'])/* ->query() */;

            if (isset($credentials['search'])) {
                $search = '%'.$credentials['search'].'%';
                $response
                ->orWhere('name', 'LIKE', $search);
            }

            $message    = ['message' => [__('list'), ]];
            $status     = 'success';
            $data       = $response->paginate(10);

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message    = ['message' => [__('Something is not right')]];
        $status     = 'warning';
        $data       = false;
        $notify     = true;

        $credentials = $request->only([
            'name',
            'description',
        ]);

        $validation = Validator::make($credentials,[
            'name'              => 'required|max:150|min:3|string|unique:brands,name',
            'description'       => 'sometimes|required|max:150|min:3|string',
        ]);

        if (!$validation->fails()) {

            $okCreate = Brand::create($credentials);

            if ($okCreate) {
                $message    = ['message' => [__('Item saved')]];
                $status     = 'success';
                $data       = $okCreate;
            } else {
                $message    = ['message' => [__('Something is not right')]];
                $status     = 'warning';
                $data       = false;
            }

        }else{
            $message    = $validation->messages();
            $status     = 'warning';
            $data       = false;

        }

        return response([
            'data'      => $data,
            'status'    => $status,
            'message'   => $message
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        $message    = ['message' => [__('Access Data')]];
        $status     = 'success';
        $data       = $brand->withCount(['product']);

        return response([
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $message    = ['message' => [__('Something is not right')]];
        $status     = 'warning';
        $data       = false;
        $notify     = true;

        $credentials = $request->only([
            'name',
            'description',
            'disabled',
        ]);

        $validation = Validator::make($credentials,[
            'name'          => 'sometimes|required|max:150|min:3|string|unique:brands,name,'.$brand->id,
            'description'   => 'sometimes|required|max:150|min:3|string',
            'disabled'      => 'sometimes|required|boolean',
        ]);

        if (!$validation->fails()) {

            foreach ($credentials as $key => $value) {
                if ($credentials[$key] == $brand[$key]) {
                    unset($credentials[$key]);
                }
            }

            if (count($credentials)) {

                $okUpdate = $brand->fill($credentials)->save();

                if ($okUpdate) {
                    $message    = ['message' => [__('Update item')]];
                    $status     = 'success';
                    $data       = $okUpdate;
                } else {
                    $message    = ['message' => [__('Something is not right')]];
                    $status     = 'success';
                    $data       = false;
                }
            } else {
                $message    = ['message' => [__('Nothing new to update')]];
                $status     = 'warning';
                $data       = false;
            }

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $okDelete = $brand->delete();

        if ($okDelete) {
            $message    = ['message' => [__('Deleted item')]];
            $status     = 'success';
            $data       = false;
        } else {
            $message    = ['message' => [__('Something is not right')]];
            $status     = 'warning';
            $data       = false;
        }

        return response([
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }
}
