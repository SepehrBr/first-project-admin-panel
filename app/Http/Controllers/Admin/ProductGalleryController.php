<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $images = $product->gallery()->latest()->paginate(20);
        return view('admin.products.gallery.all-gallery', [
            'product' => $product,
            'images' => $images
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.products.gallery.create-gallery', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $valid_data = $request->validate([
            'images.*.image' => ['required'],
            'images.*.alt' => ['required'],
        ]);

    // foreach or this method =>
        collect($valid_data['images'])->each(function ($image) use ($product) {
            $product->gallery()->create($image);
        });

        Alert::success('done','successfully created!');

        return redirect(route('admin.products.gallery.index', ['product' => $product->id]));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, ProductGallery $gallery)
    {
        return view('admin.products.gallery.edit-gallery', [
            'product' => $product,
            'gallery' => $gallery
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Product $product, ProductGallery $gallery)
    {
        $valid_data = $request->validate([
            'image' => ['required'],
            'alt' => ['required'],
        ]);

        $gallery->update($valid_data);

        Alert::success('update','update completed!');

        return redirect(route('admin.products.gallery.index', ['product' => $product->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy( Product $product, ProductGallery $gallery)
    {
        $gallery->delete();

        Alert::success('delete','successfully deleted!');

        return redirect(route('admin.products.gallery.index', ['product' => $product->id]));
    }
}
