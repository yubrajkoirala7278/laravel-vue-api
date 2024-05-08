<?php

namespace App\Service;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    // ==========ADD Product============
    public function addService($request)
    {
        $validatedData = $request->validated();

        // generate slug from name of product
        $slug = Str::slug($request->name);
        $count = Product::where('slug', $slug)->count();
        $slug = $count ? $slug . '-' . ($count + 1) : $slug;
        $validatedData['slug'] = $slug;

        //  save image in storage folder
        if ($request->hasFile('image')) {
            $imageName = null;
            $timestamp = now()->timestamp;
            $originalName = $request->file('image')[0]->getClientOriginalName();
            $imageName = $timestamp . '-' . $originalName;
            $request->file('image')[0]->storeAs('public/images/products', $imageName);
            $validatedData['image'] = $imageName;
        }

        // store in db
        $product = Product::create($validatedData);
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
