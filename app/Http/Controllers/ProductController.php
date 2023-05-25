<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $product = Product::all();

        return $this->sendResponse(ProductResource::collection($products), 'Production retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($input);

        return $this->sendResponse(new ProductResource($product), 'Product created succesfully.');
    }

    public function show($id): JsonResponse
    {
        $product = Product::find($id);

        if(is_null($product)){
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResponse($product), 'Product retrieved successfully.');
    }

    public function update(Request $request, Product $product): Jsonresponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated succesfully.');
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
