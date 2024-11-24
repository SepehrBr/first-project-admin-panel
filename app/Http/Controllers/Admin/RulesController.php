<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidateRule;
use RealRashid\SweetAlert\Facades\Alert;

class RulesController extends Controller
{

    public function __construct() {
        $this->middleware('can:show-rules')->only(['index']);
        $this->middleware('can:create-rule')->only(['create', 'store']);
        $this->middleware('can:edit-rule')->only(['edit', 'update']);
        $this->middleware('can:delete-rule')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Rule::query();
        if ($keyword = request('search')) {
            $rules->where('name', 'LIKE', "%{$keyword}%")->orWhere('label', 'LIKE', "%{$keyword}%")->orWhere('id', "%{$keyword}%");
        }

        $rules = $rules->orderByDesc('id')->paginate(20);

        return view('admin.rules.all-rules', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rules.create');
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
            'name' => ['required', 'string', 'max:255', 'unique:rules'],
            'label' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array']
        ]);

        $rule = Rule::create($validateData);
        $rule->permissions()->sync($validateData['permissions']);

        Alert::success('Rule created!', 'Rule Successfully Created!');

        return redirect(route('admin.rules.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function show(Rule $rule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function edit(Rule $rule)
    {
        return view('admin.rules.edit', [
            'rule' => $rule
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rule $rule)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255', ValidateRule::unique('rules')->ignore($rule->id)],
            'label' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array']
        ]);

        $rule->permissions()->sync($validated_data['permissions']);
        $rule->update($validated_data);

        Alert::success('Rule Updated!', 'Rule Successfully Updated!');

        return redirect(route('admin.rules.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rule $rule)
    {
        $rule->delete();
        Alert::success('Permission Deleted!', 'Permission Successfully Deleted!');
        return back();
    }
}
