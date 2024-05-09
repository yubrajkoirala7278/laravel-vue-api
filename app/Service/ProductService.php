<?php

namespace App\Service;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    // =========GET Products============
    public function fetchService($request)
    {
        $productQuery = Product::query()->latest();

        // filter
        if (!empty($request['keyword'])) {
            $productQuery->where('name', 'like', '%' . $request['keyword'] . '%')->orWhere('price', '=', $request['keyword']);
        }

        // pagination
        $perPage = $request['perPage'] ?? 10;
        $products = $productQuery->paginate($perPage);

        return $products;
    }

    // =================================


    // ==========ADD Product============
    public function addService($request)
    {
        //  save image in storage folder
        if (isset($request['image'])) {
            $imageName = null;
            $timestamp = now()->timestamp;
            $originalName = $request['image'][0]->getClientOriginalName();
            $imageName = $timestamp . '-' . $originalName;
            $request['image'][0]->storeAs('public/images/products/', $imageName);
            $request['image'] = $imageName;
        }

        // store in db
        $product = Product::create($request);
        return $product;
    }

    // ============UPDATE Product================
    public function updateService($request, $product)
    {
        // Check if a new image is uploaded
        if (isset($request['image'])) {
            // Delete the old image from storage folder
            Storage::delete('public/images/products/' . $product->image);
            // Store the new image
            $timestamp = now()->timestamp;
            $originalName = $request['image'][0]->getClientOriginalName();
            $imageName = $timestamp . '-' . $originalName;
            $request['image'][0]->storeAs('public/images/products', $imageName);
            // Update the image name in the $request array
            $request['image'] = $imageName;
        }
        // update in db
        $product->update($request);
        return $product;
    }

    // ========DELETE Product============
    public function deleteService($product)
    {
        // delete image from local storage
        if (isset($product->image)) {
            Storage::delete('public/images/products/' . $product->image);
        }
        $product->delete();
    }
}
