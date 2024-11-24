<?php

namespace Modules\Discount\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $this->seo()->setTitle('Discount');

        $discounts = Discount::latest()->paginate(30);
        return view('discount::admin.all-discounts', [
            'discounts' => $discounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // $this->seo()->setTitle('Create Discount');
        return view('discount::admin.create-discount');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $valid_data = $request->validate([
            'code' => ['required', 'unique:discounts,code'],
            'percent' => ['required', 'integer', 'min:1', 'max:99'],
            'users' => ['nullable', 'array', 'exists:users,id'],
            'products' => ['nullable', 'array', 'exists:products,id'],
            'categories' => ['nullable', 'array', 'exists:categories,id'],
            'expired_at' => ['required'],
        ]);

        $discount = Discount::create($valid_data);

        $discount->users()->attach($valid_data['users']);
        $discount->products()->attach($valid_data['products']);
        $discount->categories()->attach($valid_data['categories']);

        return redirect(route('admin.discount.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Discount $discount)
    {
        // $this->seo()->setTitle('Edit Discount');
        return view('discount::admin.edit-discount', [
            'discount' => $discount
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Discount $discount)
    {
        $valid_data = $request->validate([
            'code' => ['required', Rule::unique('discounts', 'code')->ignore($discount->id)],
            'percent' => ['required', 'integer', 'min:1', 'max:99'],
            'users' => ['nullable', 'array', 'exists:users,id'],
            'products' => ['nullable', 'array', 'exists:products,id'],
            'categories' => ['nullable', 'array', 'exists:categories,id'],
            'expired_at' => ['required'],
        ]);

        $discount->update($valid_data);

        isset($valid_data['users']) ? $discount->users()->sync($valid_data['users']) : $discount->users()->detach();
        isset($valid_data['products']) ? $discount->products()->sync($valid_data['products']) : $discount->products()->detach();
        isset($valid_data['categories']) ? $discount->categories()->sync($valid_data['categories']) : $discount->categories()->detach();

        return redirect(route('admin.discount.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back();
    }
}
