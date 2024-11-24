<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::query();
        if ($keyword = request('search')) {
            $categories->where('name', 'LIKE', "%$keyword%");
        }

        $categories = $categories->where('parent', 0)->latest()->paginate(10);
        return view('admin.categories.all-categories', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create-category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
// return $request->all();
        // create sub-category
        if ($request->parent) {
            $request->validate([
                'parent' => ['required', 'exists:categories,id', 'array']
            ]);
        }

        // create category
        $request->validate([
            'name' => ['required', 'min:3']
        ]);

        if (request('parent')) {
            foreach ($request->parent as $parent) {
                Category::create([
                    'name' => $request->name,
                    'parent' => $parent
                ]);
            }
        } else {
            Category::create([
                'name' => $request->name,
            ]);
        }
        return redirect(route('admin.categories.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit-category', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // return $request->all();
        if ($request->parent) {
            $request->validate([
                'name' => ['required', 'min:2'],
                'parent' => ['required', 'exists:categories,id', 'array']
            ]);

            foreach ($request->parent as $parent) {
                if ($parent != $category->parent) {
                    Category::create([
                        'name' => $request->name,
                        'parent' => $parent
                    ]);
                } else {
                    $category->update([
                        'name' => $request->name,
                    ]);
                }
            }
        } else {
            $request->validate([
                'name' => ['required', 'min:3']
            ]);

            $category->update([
                'name' => $request->name,
            ]);
        }



        return redirect(route('admin.categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
