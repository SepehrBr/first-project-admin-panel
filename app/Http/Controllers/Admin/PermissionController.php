<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('can:show-permissions')->only(['index']);
        $this->middleware('can:create-permission')->only(['create', 'store']);
        $this->middleware('can:edit-permission')->only(['edit', 'update']);
        $this->middleware('can:delete-permission')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::query();
        if ($keyword = request('search')) {
            $permissions->where('name', 'LIKE', "%{$keyword}%")->orWhere('label', 'LIKE', "%{$keyword}%")->orWhere('id', "%{$keyword}%");
        }

        $permissions = $permissions->orderBy('id', 'desc')->paginate(20);

        return view('admin.permissions.all-permissions', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
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
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'label' => ['required', 'string', 'max:255']
        ]);

        Permission::create($validateData);

        Alert::success('Permission created!', 'Permission Successfully Created!');

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'label' => ['required', 'string', 'max:255'],
        ]);

        $permission->update($validated_data);

        Alert::success('Permission Updated!', 'Permission Successfully Updated!');

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        Alert::success('Permission Deleted!', 'Permission Successfully Deleted!');
        return back();
    }
}
