<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    function __construct()
    {
        $this->productService = new ProductService();
    }


    public function index(Request $request)
    {
        try {
            // return ProductResource::collection(Product::all());
            // return ProductResource::collection(Product::latest()->paginate($request->perPage));
            $products = Product::latest()->paginate($request->perPage);
            return new ProductCollection($products);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function show(Product $product)
    {
        try{
            return new ProductResource($product);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->addService($request);
            // Return the created product as a JSON response
            return response()->json([
                'message' => 'Product added successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $updatedProduct = $this->productService->updateService($request->except('_method'), $product);
            $aaa = new ProductResource($updatedProduct);
            return response()->json([
                'message' => 'Product updated successfully!',
                'product' => $aaa
            ]);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }


    public function destroy(Product $product)
    {
        try {
            $this->productService->deleteService($product);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
        return response()->json('Product deleted successfully');
    }
}
