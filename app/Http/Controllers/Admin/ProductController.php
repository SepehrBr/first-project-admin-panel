<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->seo()->setTitle('Products');

        $products = Product::query();
        if ($keyword = request('search')) {
            $products->where('title', 'LIKE', "%{$keyword}%")->orWhere('description', 'LIKE', "%{$keyword}%")->orWhere('inventory', 'LIKE', "%{$keyword}%")->orWhere('price', 'LIKE', "%{$keyword}%")->orWhere('id', "%{$keyword}%");
        }

        $products = $products->orderBy('id', 'desc')->paginate(20);

        /*  sth extra to learn

    1) Product::has('comment')->get(); =>   this method returns products that has comments
    2) Product::desntHave('comment')->get(); =>   this method returns products that desnt have comments
    3) Product::withCount('comment')->get(); =>   automaticlly adds comment_count property to the product attributes without need of creating comment_count table or code blocks
    */

        return view('admin.products.all-products', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->seo()->setTitle('Create Product');
        return view('admin.products.create-product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'inventory' => ['required'],
            'price' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:20480'],
            'categories' => ['required', 'array'],
        ]);

/*          if you are using file manager you dont need this section
// get file from input and move it to public
    // get image from request
        $file = $request->file('image');
    // set path
        $destination_path = '/images/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
    // save to public dir
        $file->move(public_path($destination_path), $file->getClientOriginalName());
    // set image name in url format
        $validateData['image'] = $destination_path . $file->getClientOriginalName();
*/

        $product = auth()->user()->products()->create($validateData);
        $product->categories()->sync($validateData['categories']);


        Alert::success('Product created!', 'Product Successfully Created!');

        return redirect(route('admin.products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit-product', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated_data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'inventory' => ['required'],
            'price' => ['required'],
            // 'image' => ['required'],
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:20480'],
            'categories' => ['required', 'array'],
            // 'attributes' => 'array'
        ]);

/*  if using file manager this code block wont be needed

        if ($request->file('image')) {
            $validated_data = $request->validate([
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:20480'],
            ]);

            File::exists(public_path($product->image)) && File::delete(public_path($product->image));

            $file = $request->file('image');
            $destination_path = '/images/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
            $file->move(public_path($destination_path), $file->getClientOriginalName());
            $validated_data['image'] = $destination_path . $file->getClientOriginalName();
        }
*/

    // save files in storage in a specific disk (with original name) =>
        // Storage::putFile('files', $request->file('file'));
        Storage::disk('public')->putFileAs('files', $request->file('file'), $request->file('file')->getClientOriginalName());

        $product->update($validated_data);
        $product->categories()->sync($validated_data['categories']);

        /* attribute lesson
        // $attributes = collect($validated_data['attributes']);
        // $attributes->each(function ($item) use ($product) {
        //     if (is_null($item['name'] || is_null($item['value']))) return;

        //     $attr = Attribute::firstOrCreate([
        //         'name' => $item['name']
        //     ]);

        //     $attr_value = $attr->values()->firstOrCreate([
        //         'value' => $item['value']
        //     ]);

        //     $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        // });
        */


        Alert::success('Product Updated!', 'Product Successfully Updated!');

        return redirect(route('admin.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Alert::success('Product Deleted!', 'Product Successfully Deleted!');
        return back();
    }
}
