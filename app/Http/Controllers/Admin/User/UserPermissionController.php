<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserPermissionController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.permissions', [
            'user' => $user
        ]);
    }
    public function store(Request $request, User $user)
    {
        // $validated_data = $request->validate([
        //     'permissions' => ['required', 'array'],
        //     'rules' => ['required', 'array']
        // ]);

        // $user->permissions()->sync($validated_data['permissions']);
        // $user->rules()->sync($validated_data['rules']);


        $user->permissions()->sync($request->permissions);
        $user->rules()->sync($request->rules);

        Alert::success('done', 'done');

        return redirect(route('admin.users.index'));
    }
}
